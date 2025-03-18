package main
import (
	"fmt"
    "database/sql"
    _ "github.com/go-sql-driver/mysql"
    "net/http"
    "html/template"
    "log"
	"strconv"
)

type form struct{
	id int
	fio string
	tel string
	email string
	gender string
	date string
	bio string
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


		row, err := database.Query("SELECT id FROM u68676.forms ORDER BY id DESC LIMIT 1")
		if err != nil {
			log.Println(err)
		}
		defer row.Close()
		id, err := strconv.Atoi(row)
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
		}
	} else {
		http.ServeFile(w, r, "../front/index.html")
	}
}

func main() {
	db, err := sql.Open("mysql", "u68676:8999741@/u68676")
	if err != nil {
		log.Println(err)
	}
	database = db
	defer db.Close()
	http.HandleFunc("../front", CreateHandler)
	fmt.Println("Server is listening...")
	http.ListenAndServe(":80", nil)
}