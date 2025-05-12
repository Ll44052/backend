<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="task" content="bd" charset="UTF-8"/>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <title>Задание номер 5</title>
    </head>
    <body>
        <div class="midblocks">
            <?php
                if (!empty($messages)) {
                print('<div id="messages">');
                foreach ($messages as $message) {
                    print($message);
                }
                print('</div>');
                }
            ?>
            <form method="POST" action="input.php">
                <h1 class="midheader">Форма</h1>
                <label>
                    ФИО:
                    <br/>
                    <input name="Fio" <?php if ($errors['fio'] || $errors['fio_f'] || $errors['fio_s']) {print 'class="error"';} ?> value="<?php if ($values['fio']===''){print '';}else {print $values['fio'];}?>" />
                </label>
                <br/><br/><br/>
                <label>
                    Номер телефона:
                    <br/>
                    <input name="Tel" type="tel" <?php if ($errors['tel'] || $errors['tel_f'] || $errors['tel_s']) {print 'class="error"';} ?> value="<?php if ($values['tel']===''){print '+7';}else {print $values['tel'];}?>" />
                </label>
                <br/><br/><br/>
                <label>
                    e-mail:
                    <br/>
                    <input name="Email" type="email" <?php if ($errors['email'] || $errors['email_f'] || $errors['email_s']) {print 'class="error"';} ?> <?php if ($values['email']===''){print 'placeholder="user@example.org"';}else {print 'value = "'; print $values['email'];print '"';}?>  />
                </label>
                <br/><br/><br/>
                <label>
                    Дата рождения:
                    <br/>
                    <input name="Birth_date" type="date" <?php if ($errors['birth_date']) {print 'class="error"';} ?> value="<?php print $values['birth_date']; ?>"/>
                </label>
                <br/><br/><br/>
                <label>
                    Пол:
                    <br/>
                    <input type="radio" name="Gender" value="Male" <?php if ($values['gender']==='Male'){print 'checked';}?> <?php if ($errors['gender']) {print 'class="error"';} ?> />
                    Мужчина
                </label>
                <br/>
                <label>
                    <input type="radio" name="Gender" value="Female"<?php if ($values['gender']==='Female'){print 'checked';}?> <?php if ($errors['gender']) {print 'class="error"';} ?> />
                    Женщина
                </label>
                <br/><br/><br/>
                <label>
                    <?php $items = explode(' ', $values['favlangs']);?>
                    <select name="Favlangs[]" multiple="multiple" <?php if ($errors['favlangs']) {print 'class="error"';} ?>>
                        <option value="1" <?php if (in_array("1", $items) || empty($items)){print 'selected="selected"';}?>>Prolog</option>
                        <option value="2" <?php if (in_array("2", $items)){print 'selected="selected"';}?>>JavaScript</option>
                        <option value="3" <?php if (in_array("3", $items)){print 'selected="selected"';}?>>PHP</option>
                        <option value="4" <?php if (in_array("4", $items)){print 'selected="selected"';}?>>C++</option>
                        <option value="5" <?php if (in_array("5", $items)){print 'selected="selected"';}?>>Java</option>
                        <option value="6" <?php if (in_array("6", $items)){print 'selected="selected"';}?>>C#</option>
                        <option value="7" <?php if (in_array("7", $items)){print 'selected="selected"';}?>>Haskell</option>
                        <option value="8" <?php if (in_array("8", $items)){print 'selected="selected"';}?>>Clojure</option>
                        <option value="9" <?php if (in_array("9", $items)){print 'selected="selected"';}?>>Scala</option>
                        <option value="10" <?php if (in_array("10", $items)){print 'selected="selected"';}?>>Pascal</option>
                        <option value="11" <?php if (in_array("11", $items)){print 'selected="selected"';}?>>Python</option>
                    </select>
                </label>
                <br/><br/><br/>
                <label>
                    Биография:
                    <br/>
                    <textarea name="Bio" <?php if ($errors['bio']) {print 'class="error"';} ?>> <?php print $values['bio']; ?> </textarea>
                </label>
                <br/><br/><br/>
                <label>
                    <input type="checkbox" name="Familiar" <?php if ($values['familiar']!==''){print 'checked';}?> <?php if ($errors['familiar']) {print 'class="error"';} ?>/>
                    С контрактом ознакомлен(а)
                    <br/>
                    <input type="submit" value="Отправить форму"/>
                    <br/>
                    
                </label>
            </form>
            <?php
                if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) {
                    print '<form method="POST" action="logout.php"><input type="submit" value="Выйти из учетной записи"/></form>';
                }
            ?>
        </div>
    </body>
</html>