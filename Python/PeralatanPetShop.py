class PeralatanPetShop:
    # constructor
    def __init__(self, id, nama, kategori, harga):
        self.id = id
        self.nama = nama
        self.kategori = kategori
        self.harga = harga

    # getter
    def get_id(self):
        return self.id

    def get_nama(self):
        return self.nama

    def get_kategori(self):
        return self.kategori

    def get_harga(self):
        return self.harga

    # setter
    def set_nama(self, nama):
        self.nama = nama

    def set_kategori(self, kategori):
        self.kategori = kategori

    def set_harga(self, harga):
        self.harga = harga
