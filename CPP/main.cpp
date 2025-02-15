#include "PeralatanPetShop.cpp"
#include <list>

// cek apakah id sudah ada di list
int isIdExist(list<PeralatanPetShop> peralatanPetShopList, string id) {
    for (auto p : peralatanPetShopList) {
        if (p.getId() == id) return 1;
    }
    return 0;
}

int main() {
    list<PeralatanPetShop> peralatanPetShopList;

    // variabel sementara untuk menampung inputan user
    string id;
    string nama;
    string kategori;
    int harga;

    /**
     * menu ada 5:
     *   1. Create
     *   2. Read
     *   3. Update
     *   4. Delete
     *   5. Exit
     */
    char menu;

    // loop sampai user memilih exit
    do {
        cout << endl
             << "--- [ menu ] ---" << endl
             << "1. create" << endl
             << "2. read" << endl
             << "3. update" << endl
             << "4. delete" << endl
             << "5. exit" << endl
             << endl
             << "Pilih menu: ";
        cin >> menu;

        if (menu == '1') { // create

            cout << "id nya apa? (harus unik) : ";
            cin >> id;
            cout << "nama peralatan (gaboleh pake spasi): ";
            cin >> nama;
            cout << "kategori peralatan (gaboleh pake spasi) : ";
            cin >> kategori;
            cout << "harga peralatan (harus angka) : ";
            cin >> harga;

            // cek apakah id sudah ada? hanya add jika belum ada
            if (isIdExist(peralatanPetShopList, id)) {
                cout << "id sudah ada :(" << endl;
            } else {
                PeralatanPetShop tmp(id, nama, kategori, harga);
                peralatanPetShopList.push_back(tmp);
            }
        } else if (menu == '2') { // read
            cout << endl
                 << "--- [ daftar peralatan pet shop ] ---" << endl;
            cout << "id | nama | kategori | harga" << endl;
            for (auto p : peralatanPetShopList) {
                cout << p.getId() << " | " << p.getNama() << " | " << p.getKategori() << " | " << p.getHarga() << endl;
            }
        } else if (menu == '3') { // update
            cout << "id: ";
            cin >> id;
            cout << "nama: ";
            cin >> nama;
            cout << "kategori: ";
            cin >> kategori;
            cout << "harga: ";
            cin >> harga;

            int found = 0;
            for (auto &p : peralatanPetShopList) {
                if (p.getId() == id) {
                    p.setNama(nama);
                    p.setKategori(kategori);
                    p.setHarga(harga);
                    found = 1;
                }
            }
            if (!found) {
                cout << "id tidak ditemukan :(" << endl;
            }
        } else if (menu == '4') { // delete
            cout << "id: ";
            cin >> id;
            int found = 0;
            auto it = peralatanPetShopList.begin();
            while (!found && it != peralatanPetShopList.end()) {
                if (it->getId() == id) {
                    it = peralatanPetShopList.erase(it);
                    found = 1;
                } else {
                    ++it;
                }
            }
            if (!found) {
                cout << "id tidak ditemukan :(" << endl;
            }
        } else if (menu == '5') {
            cout << "kamu keluar dari menu :)" << endl;
        } else {
            cout << "menu gk valid :(" << endl;
        }
    } while (menu != '5');

    return 0;
}
