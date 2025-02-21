from PeralatanPetShop import PeralatanPetShop


def is_id_exist(list_peralatan, id):  # cari index dari peralatan dengan id tertentu
    for i, peralatan in enumerate(list_peralatan):
        if peralatan.get_id() == id:
            return i  # return index jika id ditemukan
    return -1  # return -1 jika id tidak ditemukan


# cari peralatan berdasarkan nama. output berupa list
def search_by_name(list_peralatan, nama):
    results = []
    for peralatan in list_peralatan:
        if nama.lower() in peralatan.get_nama().lower():
            results.append(peralatan)
    return results


def print_peralatan(list_peralatan):  # print list peralatan
    for p in list_peralatan:
        print(
            f"{p.get_id()} | {p.get_nama()} | {p.get_kategori()} | {p.get_harga()}")


def main():  # main program
    list_peralatan = []  # list peralatan

    # main loop
    while True:
        print("--- [ menu ] ---")
        print("1. create")
        print("2. read")
        print("3. update")
        print("4. delete")
        print("5. search (by name)")
        print("6. exit\n")
        menu = input("pilih menu: ")

        if menu == '1':  # create
            id = input("id: ")
            # cek apakah id sudah ada
            if is_id_exist(list_peralatan, id) != -1:
                print("id sudah ada")
            else:
                # belum ada id, lanjutkan proses input
                nama = input("nama: ")
                kategori = input("kategori: ")
                harga = int(input("harga: "))
                list_peralatan.append(
                    PeralatanPetShop(id, nama, kategori, harga))
                print("data berhasil ditambahkan")

        elif menu == '2':  # read
            print("--- [ daftar peralatan pet shop ] ---")
            print_peralatan(list_peralatan)

        elif menu == '3':  # update
            id = input("id: ")
            # cek apakah id ada
            index = is_id_exist(list_peralatan, id)
            if index == -1:
                print("id tidak ditemukan")
            else:
                # id ditemukan, lanjutkan proses update
                nama = input("nama baru: ")
                kategori = input("kategori baru: ")
                harga = int(input("harga baru: "))
                list_peralatan[index].set_nama(nama)
                list_peralatan[index].set_kategori(kategori)
                list_peralatan[index].set_harga(harga)
                print("update selesai")

        elif menu == '4':  # delete
            id = input("id: ")
            # cek apakah id ada
            index = is_id_exist(list_peralatan, id)
            if index == -1:
                print("id tidak ditemukan")
            else:
                # id ditemukan, lanjutkan proses delete
                list_peralatan.pop(index)
                print("delete selesai")

        elif menu == '5':  # search by Name
            search_term = input("nama yang ingin dicari: ")
            # cari peralatan berdasarkan nama
            results = search_by_name(list_peralatan, search_term)
            if results:
                # ada hasil pencarian, print isinya
                print_peralatan(results)
            else:
                print("tidak ditemukan peralatan dengan nama tersebut.")

        elif menu == '6':  # exit
            print("byebyee")
            break

        else:
            print("pilihan menu tidak tersedia")

# run the program
if __name__ == "__main__":
    main()
