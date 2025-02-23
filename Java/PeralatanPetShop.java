
class PeralatanPetShop {
    String id;
    String nama;
    String kategori;
    int harga;

    // constructor
    PeralatanPetShop(String id, String nama, String kategori, int harga) {
        this.id = id;
        this.nama = nama;
        this.kategori = kategori;
        this.harga = harga;
    }

    // getter
    String getId() {
        return id;
    }

    String getNama() {
        return nama;
    }

    String getKategori() {
        return kategori;
    }

    int getHarga() {
        return harga;
    }

    // setter
    void setNama(String nama) {
        this.nama = nama;
    }

    void setKategori(String kategori) {
        this.kategori = kategori;
    }

    void setHarga(int harga) {
        this.harga = harga;
    }
}
