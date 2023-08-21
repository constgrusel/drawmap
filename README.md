# drawmap
Drawing automation of plots given latitude and longitude

 Bu kod, uygun formattaki (TKGM sistem formatı) bir JSON dosyasını yükleyerek içerisindeki koordinatları haritalandıran bir web sayfasını oluşturur. İşleyişini şu şekilde açıklayabiliriz:

1. HTML formu, kullanıcıya bir JSON dosyası yüklemesi için bir alan sunar.
2. Form gönderildiğinde, PHP tarafında form verileri işlenir ve yüklenen dosya kontrol edilir.
3. Dosya hatasız bir şekilde yüklendiyse, dosya içeriği `file_get_contents` fonksiyonuyla okunur.
4. JSON verisi `json_decode` fonksiyonuyla çözümlenir ve `$veri` değişkenine atanır.
5. `$veri` değişkeni doğru bir şekilde çözümlendiğinde, sadece "coordinates" kısmı `$coordinates` değişkenine atanır.
6. `$coordinates` değişkeni JSON formatında biçimlendirilerek `$formattedCoordinates` değişkenine atanır.
7. Ardından `$formattedCoordinates` değişkeninin köşeli parantezleri kaldırılır ve sadece koordinatlar elde edilir.
8. Web sayfasında, çizim yapmak için bir canvas elementi oluşturulur.
9. `drawTarla` fonksiyonu, enlem ve boylam koordinatlarını kullanarak tarla sınırlarını çizer.
10. Tarla sınırları, enlem ve boylam koordinatlarının min ve max değerleriyle belirlenir.
11. Daha sonra ölçeklendirme işlemi yapılır ve tarla sınırları çizilir.
12. Son olarak, çizimler canvas üzerine çizilir.

Bu kod, bir JSON dosyasını yükleyerek içerisindeki koordinatları haritalandırmak için basit bir yöntem sunmaktadır.
