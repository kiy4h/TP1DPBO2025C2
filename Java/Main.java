import java.util.Scanner;
import java.util.ArrayList;

public class Main {
    // fungsi untuk mengecek apakah id sudah ada di listPeralatan
    static int isIdExist(ArrayList<PeralatanPetShop> listPeralatan, String id) {
        for (int i = 0; i < listPeralatan.size(); i++) {
            if (listPeralatan.get(i).getId().equals(id))
                return i; // return index jika id ditemukan
        }
        return -1; // return -1 jika id tidak ditemukan
    }

    // fungsi untuk mencari peralatan berdasarkan nama
    static void searchByName(ArrayList<PeralatanPetShop> listPeralatan, String nama) {
        boolean found = false; // flag untuk mengecek apakah peralatan ditemukan
        System.out.println("--- [ Hasil Pencarian ] ---");
        for (PeralatanPetShop peralatan : listPeralatan) {
            if (peralatan.getNama().toLowerCase().contains(nama.toLowerCase())) {
                System.out.println(peralatan.getId() + " | " + peralatan.getNama() + " | "
                        + peralatan.getKategori() + " | " + peralatan.getHarga());
                found = true;
            }
        }
        if (!found) {
            System.out.println("Tidak ditemukan peralatan dengan nama tersebut.");
        }
    }

    public static void main(String[] args) {

        // arraylist yg akan dilakukan CRUD
        ArrayList<PeralatanPetShop> listPeralatan = new ArrayList<PeralatanPetShop>();

        // variabel sementara untuk menampung inputan user
        String id, nama, kategori;
        int harga;

        /**
         * menu ada 6:
         * 1. create
         * 2. read
         * 3. update
         * 4. delete
         * 5. search (by name)
         * 6. exit
         */
        char menu;
        Scanner scanner = new Scanner(System.in);

        // loop sampai user memilih exit
        do {
            // print menu
            System.out.println("\n--- [ menu ] ---");
            System.out.println("1. create");
            System.out.println("2. read");
            System.out.println("3. update");
            System.out.println("4. delete");
            System.out.println("5. search (by name)");
            System.out.println("6. exit\n");
            System.out.print("pilih menu: ");
            menu = scanner.next().charAt(0);

            switch (menu) {
                case '1': // create
                    System.out.print("id: ");
                    id = scanner.next();
                    if (isIdExist(listPeralatan, id) != -1) {
                        System.out.println("id sudah ada");
                    } else {
                        System.out.print("nama: ");
                        nama = scanner.next();
                        System.out.print("kategori: ");
                        kategori = scanner.next();
                        System.out.print("harga: ");
                        harga = scanner.nextInt();
                        listPeralatan.add(new PeralatanPetShop(id, nama, kategori, harga));
                        System.out.println("data berhasil ditambahkan");
                    }
                    break;
                case '2': // read
                    System.out.println("--- [ Daftar peralatan pet shop ] ---");
                    for (int i = 0; i < listPeralatan.size(); i++) {
                        System.out.println(listPeralatan.get(i).getId() + " | " + listPeralatan.get(i).getNama() + " | "
                                + listPeralatan.get(i).getKategori() + " | " + listPeralatan.get(i).getHarga());
                    }
                    break;
                case '3': // update
                    System.out.print("id: ");
                    id = scanner.next();
                    if (isIdExist(listPeralatan, id) == -1) {
                        System.out.println("id tidak ditemukan");
                    } else {
                        System.out.print("nama: ");
                        nama = scanner.next();
                        System.out.print("kategori: ");
                        kategori = scanner.next();
                        System.out.print("harga: ");
                        harga = scanner.nextInt();
                        listPeralatan.get(isIdExist(listPeralatan, id)).setNama(nama);
                        listPeralatan.get(isIdExist(listPeralatan, id)).setKategori(kategori);
                        listPeralatan.get(isIdExist(listPeralatan, id)).setHarga(harga);
                        System.out.println("update selesai");
                    }
                    break;
                case '4': // delete
                    System.out.print("id: ");
                    id = scanner.next();
                    int index = isIdExist(listPeralatan, id);
                    if (index == -1) {
                        System.out.println("id tidak ditemukan");
                    } else {
                        listPeralatan.remove(index);
                        System.out.println("delete selesai");
                    }
                    break;
                case '5': // search (by name)
                    System.out.print("nama yang ingin dicari: ");
                    nama = scanner.next();
                    searchByName(listPeralatan, nama);
                    break;
                case '6': // exit
                    System.out.println("byebyee");
                    break;
                default:
                    System.out.println("pilihan menu tidak tersedia :(");
                    break;
            }
        } while (menu != '6');

        scanner.close(); // tutup scanner setelah user memilih exit
    }
}