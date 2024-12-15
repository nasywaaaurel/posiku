<?php
// Sesuaikan dengan setting MySQL 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "responsi";

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah ada permintaan untuk menghapus data
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Query untuk menghapus data berdasarkan delete_id
    $delete_sql = "DELETE FROM pos WHERE delete_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $delete_id); // Menggunakan parameter s untuk string
    $stmt->execute();
    $stmt->close();

    // Setelah penghapusan, arahkan kembali ke halaman utama untuk memperbarui tampilan
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Query untuk mengambil data
$sql = "SELECT * FROM pos";
$result = $conn->query($sql);

// Cek jika ada data di tabel
if ($result->num_rows > 0) {
    echo "<html><head>
            <style>
    body {
        background-color: #f5f5f5; /* Warna latar belakang halaman abu-abu terang */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff0f5; /* Background tabel warna pink terang */
    }

    th {
        background-color: #800000; /* Maroon */
        color: white;
        padding: 10px;
        text-align: center;
        font-weight: bold;
    }

    td {
        padding: 8px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    tr:hover {
        background-color: #ffd6e7; /* Light Pink */
    }

    a {
        color: #d85b9f; /* Pink */
        text-decoration: none;
        font-weight: bold;
        padding: 5px 10px;
        border: 1px solid #d85b9f;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    a:hover {
        background-color: #d85b9f; /* Pink */
        color: white;
    }

    a:active {
        transform: scale(0.95);
    }

    table {
        margin: 20px auto;
        max-width: 90%;
    }

    @media (max-width: 768px) {
        table {
            font-size: 14px;
            width: 100%;
        }
        th, td {
            padding: 5px;
        }
    }
</style>

        </head><body>";
    
    echo "<table>
            <tr> 
                <th>Nama</th> 
                <th>Alamat</th> 
                <th>Jam Buka</th> 
                <th>Jam Tutup</th> 
                <th>Action</th> 
            </tr>";

    // Output data setiap baris
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["nama"] . "</td>
                <td>" . $row["alamat"] . "</td>
                <td>" . $row["jam_buka"] . "</td>
                <td>" . $row["jam_tutup"] . "</td>
                <td><a href='?delete_id=" . $row["delete_id"] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a></td>
                </tr>";
    }

    echo "</table>"; // Penutup tabel
} else {
    echo "0 results";
}

// Tutup koneksi
$conn->close();
?>
