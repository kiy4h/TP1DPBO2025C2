<?php
    require_once 'PeralatanPetShop.php';

    // mulai session
    session_start();

    // init listnya jika belum ada
    if (! isset($_SESSION['peralatanPetShopList'])) {
        $_SESSION['peralatanPetShopList'] = [];
    }

    // get list from session
    $peralatanPetShopList = &$_SESSION['peralatanPetShopList'];

    // fungsi untuk mencari item berdasarkan id
    // return index jika ditemukan, -1 jika tidak ditemukan
    function findItemById($list, $id) {
        foreach ($list as $key => $item) {
            if ($item->getId() == $id) {
                return $key; // ketemu, return indexnya
            }
        }
        return -1; // tidak ketemu
    }

    // fungsi untuk handle file upload
    // return path file jika berhasil, '' jika gagal
    function handleFileUpload($file) {
        $uploadDir = 'uploads/'; // direktori upload
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // buat direktori jika belum ada, dengan perms 0777 (full permission)
        }
        $uploadFile = $uploadDir . basename($file['name']);       // dir + nama file yang diupload
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) { // pindahkan file dari temp ke direktori upload. jika berhasil, return nama file
            return $uploadFile;
        } else {
            return '';
        }
    }

    // handle create, update, delete
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['create'])) { // create
            $id       = $_POST['id'];
            $nama     = $_POST['nama'];
            $kategori = $_POST['kategori'];
            $harga    = $_POST['harga'];

            // cek apakah foto diupload atau tidak
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                $foto = handleFileUpload($_FILES['foto']);
                if (empty($foto)) {
                    echo "<script>alert('Error uploading file.');</script>";
                    return;
                }
            } else {
                $foto = '';
            }
            // cek apakah id sudah ada
            if (findItemById($peralatanPetShopList, $id) == -1) {
                // belum ada, create item
                $peralatanPetShopList[] = new PeralatanPetShop($id, $nama, $kategori, $harga, $foto);
                echo "<script>alert('Peralatan telah dibuat dengan sukses!');</script>";
            } else {
                echo "<script>alert('ID already exists!');</script>";
            }
        } elseif (isset($_POST['update'])) {
            $id       = $_POST['id'];
            $nama     = $_POST['nama'];
            $kategori = $_POST['kategori'];
            $harga    = $_POST['harga'];

            // cari index item berdasarkan id
            $index = findItemById($peralatanPetShopList, $id);
            if ($index != -1) {
                // ketemu, update itemnya
                if (empty($nama) && empty($kategori) && empty($harga) && empty($_FILES['foto']['name'])) {
                    // data kosong semua, tidak ada yang bisa diupdate
                    echo "<script>alert('Data kosong semua, tidak ada yang bisa diupdate.');</script>";
                } else {
                    // ubah atribut data hanya jika atribut tsb tidak null
                    if (! empty($nama)) $peralatanPetShopList[$index]->setNama($nama);
                    if (! empty($kategori)) $peralatanPetShopList[$index]->setKategori($kategori);
                    if (! empty($harga)) $peralatanPetShopList[$index]->setHarga($harga);

                    // cek apakah foto diupload atau tidak
                    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                        $foto = handleFileUpload($_FILES['foto']);
                        if (! empty($foto)) { // jika berhasil upload (string tdk kosong), set foto baru
                            $peralatanPetShopList[$index]->setFoto($foto);
                        } else {
                            // gagal upload
                            echo "<script>alert('Error uploading file.');</script>";
                            return;
                        }
                    }

                    echo "<script>alert('peralatan terupdate dengan sukses!');</script>";
                }
            } else {
                // tidak ketemu
                echo "<script>alert('ID not found!');</script>";
            }
        } elseif (isset($_POST['delete'])) {
            $id = $_POST['id'];
            // cari index item berdasarkan id
            $index = findItemById($peralatanPetShopList, $id);
            if ($index != -1) {
                // ketemu, delete itemnya
                // array_splice: hapus 1 elemen mulai dari index
                array_splice($peralatanPetShopList, $index, 1);
                echo "<script>alert('Item deleted successfully!');</script>";
            } else {
                // tidak ketemu
                echo "<script>alert('ID not found!');</script>";
            }
        }
    }

    // handle search (by name)
    $searchQuery = '';
    // jika ada search query, ambil datanya
    if (isset($_GET['search'])) {
        $searchQuery = strtolower(trim($_GET['search'])); // ambil querynya dan ubah ke lowercase
    }

    $filteredList = $peralatanPetShopList;
    // filter items berdasarkan search query jika ada
    if (! empty($searchQuery)) {
        $filteredList = array_filter($peralatanPetShopList, function ($item) use ($searchQuery) {
            $itemName = strtolower($item->getNama());         // nama itemnya
            return strpos($itemName, $searchQuery) !== false; // return true jika ada
        });
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peralatan Pet Shop</title>
    <style>
        body {
            font-family: 'Fredoka', sans-serif;
            background-color: #ffe6f2;
            color: #ff1493;
            padding: 10px;
        }

        h1, h2 {
            color: #ff69b4;
            text-align: center;
        }

        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ff69b4;
            border-radius: 5px;
            font-size: 16px;
        }

        .crud-form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: 0 auto 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .crud-form input, .crud-form input[type="file"] {
            padding: 10px;
            border: 1px solid #ff69b4;
            border-radius: 5px;
            font-size: 16px;
        }

        .crud-form button, .search-container button {
            background-color: #ff69b4;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .crud-form button:hover, .search-container button:hover {
            background-color: #ff1493;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-info h3 {
            margin: 0;
            font-size: 20px;
            color: #ff69b4;
        }

        .product-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }

        .delete-form {
            width: 100%;
            padding: 10px;
            background-color: #ffebee;
        }

        .delete-form button {
            width: 100%;
            background-color: #ff1493;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .delete-form button:hover {
            background-color: #ff0066;
        }
    </style>
</head>
<body>
    <h1>🎀 Peralatan Pet Shop 🎀</h1>

    <h2>Create/Update Peralatan</h2>
    <!-- form untuk create/update -->
    <form method="POST" class="crud-form" enctype="multipart/form-data">
        <input type="text" id="id" name="id" placeholder="ID" required>
        <input type="text" id="nama" name="nama" placeholder="Nama">
        <input type="text" id="kategori" name="kategori" placeholder="Kategori">
        <input type="number" id="harga" name="harga" placeholder="Harga">
        Foto:
        <input type="file" id="foto" name="foto" accept="image/*">
        <button type="submit" name="create">Create</button>
        <button type="submit" name="update">Update</button>
    </form>


    <!-- search bar -->
    <h2>Daftar Peralatan</h2>
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search (by name)" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- grid of products -->
    <div class="product-grid">
        <?php foreach ($filteredList as $item): ?>
            <div class="product-card">
                <img src="<?php echo $item->getFoto(); ?>" alt="<?php echo $item->getNama(); ?>">
                <div class="product-info">
                    <h3><?php echo $item->getNama(); ?></h3>
                    <p><strong>ID:</strong>
                    <?php echo $item->getId(); ?></p>
                    <p><strong>Kategori:</strong>
                    <?php echo $item->getKategori(); ?></p>
                    <p><strong>Harga:</strong> Rp
                    <?php echo number_format($item->getHarga(), 0, ',', '.'); ?></p>
                </div>
                <form method="POST" class="delete-form">
                    <input type="hidden" name="id" value="<?php echo $item->getId(); ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>