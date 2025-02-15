#include <iostream>
#include <string>

using namespace std;

class PeralatanPetShop {
private:
    string id;
    string nama;
    string kategori;
    int harga;

public:
    // constructor
    PeralatanPetShop() {}

    PeralatanPetShop(string id, string nama, string kategori, int harga) {
        this->id = id;
        this->nama = nama;
        this->kategori = kategori;
        this->harga = harga;
    }

    // setter
    void setNama(string nama) {
        this->nama = nama;
    }
    void setKategori(string kategori) {
        this->kategori = kategori;
    }
    void setHarga(int harga) {
        this->harga = harga;
    }

    // getter
    string getId() {
        return id;
    }
    string getNama() {
        return nama;
    }
    string getKategori() {
        return kategori;
    }
    int getHarga() {
        return harga;
    }

    // destructor
    ~PeralatanPetShop() {
    }
};