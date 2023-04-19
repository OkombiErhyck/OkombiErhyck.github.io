<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php const express = require('express');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const app = express();
const bodyParser = require('body-parser');
app.use(bodyParser.json());

app.post('/register', async (req, res) => {
  const { username, email, password } = req.body;
  const hashedPassword = await bcrypt.hash(password, 10);
  const query = `INSERT INTO users (username, email, password) VALUES ('${username}', '${email}', '${hashedPassword}')`;
  try {
    // executați interogarea în baza de date
    const result = await database.query(query);
    res.json({ message: 'Utilizator înregistrat cu succes' });
  } catch (error) {
    console.log(error);
    res.status(500).json({ message: 'A apărut o eroare' });
  }
});

app.post('/login', async (req, res) => {
  const { email, password } = req.body;
  const query = `SELECT * FROM users WHERE email = '${email}'`;
  try {
    // executați interogarea în baza de date
    const [result] = await database.query(query);
    if (!result) {
      return res.status(401).json({ message: 'Adresa de email sau parola sunt incorecte' });
    }
    const isMatch = await bcrypt.compare(password, result.password);
    if (!isMatch) {
      return res.status(401).json({ message: 'Adresa de email sau parola sunt incorecte' });
    }
    const token = jwt.sign({ user_id: result.user_id }, 'secretkey');
    res.json({ token });
  } catch (error) {
    console.log(error);
    res.status

</body>
</html>