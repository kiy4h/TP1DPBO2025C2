<?php
class PeralatanPetShop {
    private $id;
    private $nama;
    private $kategori;
    private $harga;
    private $foto; // path to image

    // constructor
    // untuk beberapa values yang tidak diisi (null), maka akan diisi dengan default value
    public function __construct($id, $nama, $kategori, $harga, $foto) {
        $this->id       = $id; // id harus diisi (required pada form), tidak akan null
        $this->nama     = $nama ? $nama : "tidak ada nama";
        $this->kategori = $kategori ? $kategori : "lainnya";
        $this->harga    = $harga ? $harga : 0;
        $this->foto     = $foto; // tidak ada default value, karena foto bisa kosong
    }

    // getters
    public function getId() {
        return $this->id;
    }

    public function getNama() {
        return $this->nama;
    }

    public function getKategori() {
        return $this->kategori;
    }

    public function getHarga() {
        return $this->harga;
    }

    public function getFoto() {
        return $this->foto;
    }

    // setters
    // note: tidak diperlukan set id karena id merupakan primary key
    public function setNama($nama) {
        $this->nama = $nama;
    }

    public function setKategori($kategori) {
        $this->kategori = $kategori;
    }

    public function setHarga($harga) {
        $this->harga = $harga;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }
}
