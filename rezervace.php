<?php
// Připojení k MySQL databázi
$servername = "localhost"; // adresa serveru, na kterém běží databáze
$username = "root"; // uživatelské jméno pro přístup k databázi
$password = ""; // heslo pro přístup k databázi
$dbname = "hotel"; // název databáze
// Vytvoření spojení s databází
$conn = new mysqli($servername, $username, $password, $dbname);
// Ověření spojení
if ($conn->connect_error) {
    die("Spojení s databází se nezdařilo: " . $conn->connect_error);
}
// Získání údajů z formuláře
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jmeno = $_POST["jmeno"];
    $email = $_POST["email"];
    $telefon = $_POST["telefon"];
    $datum = $_POST["datum"];
    $pocet_noci = $_POST["pocet_noci"];
    $pocet_osob = $_POST["pocet_osob"];
    // Vložení rezervace do databáze
    $sql = "INSERT INTO rezervace (jmeno, email, telefon, datum, pocet_noci, pocet_osob) VALUES ('$jmeno', '$email', '$telefon', '$datum', '$pocet_noci', '$pocet_osob')";
    if ($conn->query($sql) === TRUE) {
        // Zobrazení potvrzení o rezervaci
        echo "<p>Děkujeme za vaši rezervaci. Těšíme se na vás v hotelu Vytvor.</p>";
        echo "<p>Vaše rezervační údaje:</p>";
        echo "<ul>";
        echo "<li>Jméno: $jmeno</li>";
        echo "<li>E-mail: $email</li>";
        echo "<li>Telefon: $telefon</li>";
        echo "<li>Datum příjezdu: $datum</li>";
        echo "<li>Počet nocí: $pocet_noci</li>";
        echo "<li>Počet osob: $pocet_osob</li>";
        echo "</ul>";
    } else {
        // Zobrazení chyby při vkládání do databáze
        echo "Nastala chyba při zpracování vaší rezervace: " . $conn->error;
    }
}
// Zobrazení seznamu všech rezervací v databázi
echo "<h2>Seznam všech rezervací</h2>";
echo "<table>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>Jméno</th>";
echo "<th>E-mail</th>";
echo "<th>Telefon</th>";
echo "<th>Datum příjezdu</th>";
echo "<th>Počet nocí</th>";
echo "<th>Počet osob</th>";
echo "</tr>";
// Vybrání všech rezervací z databáze
$sql = "SELECT * FROM rezervace";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Výpis každé rezervace jako řádku tabulky
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["jmeno"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["telefon"] . "</td>";
        echo "<td>" . $row["datum"] . "</td>";
        echo "<td>" . $row["pocet_noci"] . "</td>";
        echo "<td>" . $row["pocet_osob"] . "</td>";
        echo "</tr>";
    }
} else {
    // Zobrazení zprávy, že nejsou žádné rezervace
    echo "<tr>";
    echo "<td>Nejsou žádné rezervace</td>";
    echo "</tr>";
}
// Uzavření spojení s databází
$conn->close();
?>
