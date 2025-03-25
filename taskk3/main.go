package main

import (
	"database/sql"
	"fmt"
	"log"
	"net/http"
	"strconv"

	_ "github.com/go-sql-driver/mysql"
)

type form struct {
	id       int
	fio      string
	tel      string
	email    string
	gender   string
	date     string
	bio      string
	favlangs []int
}

var database *sql.DB

func CreateHandler(w http.ResponseWriter, r *http.Request) {
	if r.Method == "POST" {
		err := r.ParseForm()
		if err != nil {
			log.Println(err)
		}
		fio := r.FormValue("Fio")
		tel := r.FormValue("Tel")
		email := r.FormValue("Email")
		gender := r.FormValue("Gender")
		date := r.FormValue("Birth_date")
		bio := r.FormValue("Bio")
		favlangs := r.Form["Favlangs"]

		_, err = database.Exec("INSERT INTO u68676.forms (fio, tel, email, gender, birth_date, bio) VALUES (?, ?, ?, ?, ?, ?)",
			fio, tel, email, gender, date, bio)

		if err != nil {
			log.Println(err)
		}

		row, err := database.Query("SELECT MAX(id) FROM forms")
		if err != nil {
			log.Println(err)
		}
		defer row.Close()
		var idStr string
		for row.Next() {
			err = row.Scan(&idStr)
			if err != nil {
				log.Println(err)
			}
		}

		id, err := strconv.Atoi(idStr)
		fmt.Println(id)
		if err != nil {
			log.Println(err)
		}

		for _, lang := range favlangs {
			id_lang, err := strconv.Atoi(lang)
			if err != nil {
				log.Println(err)
			}
			_, err = database.Exec("INSERT INTO u68676.favlangs (id, id_lang) VALUES (?, ?)", id, id_lang)
			if err != nil {
				log.Println(err)
			}
			http.Redirect(w, r, "/", 301)
		}
	} else {
		http.ServeFile(w, r, "templates/index.html")
	}
}

func main() {
	http.Handle("/static/", http.StripPrefix("/static/", http.FileServer(http.Dir("static"))))
	db, err := sql.Open("mysql", "u68676:8999741@/u68676")
	if err != nil {
		log.Println(err)
	}
	database = db
	defer db.Close()
	http.HandleFunc("/", CreateHandler)
	fmt.Println("Server is listening...")
	//cgi.Serve(http.DefaultServeMux)
	http.ListenAndServe(":8181", nil)
}
