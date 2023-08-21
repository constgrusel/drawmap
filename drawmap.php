


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['dosya'])) {
    $dosya = $_FILES['dosya'];

    if ($dosya['error'] === UPLOAD_ERR_OK) {
        $dosyaYolu = $dosya['tmp_name'];

        // JSON dosyasını oku
        $icerik = file_get_contents($dosyaYolu);

        // JSON verisini çözümle
        $veri = json_decode($icerik, true);

        if ($veri) {
            // Sadece "coordinates" kısmını çek
            $coordinates = $veri['features'][0]['geometry']['coordinates']['0'];

            // Köşeli parantezleri kaldır
           $formattedCoordinates = json_encode($coordinates, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$formattedCoordinates = substr($formattedCoordinates, 2, -2);


         
        } else {
            // JSON verisi çözümlenemedi
            echo 'JSON verisi çözümlenemedi.';

        }
    } else {
        // Dosya yükleme hatası
        echo 'Dosya yükleme hatası: ' . $dosya['error'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>JSON Dosyası Yükleme ve Coordinates Çekme</title>
</head>
<body>



    <h1>TKGM JSON KOORDİNATLARI HARİTALANDIRMA</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="dosya" accept=".json">
        <button type="submit">Yükle</button>
    </form>


    <hr><p>
        Bu kod, bir JSON dosyasını yükleyerek içerisindeki koordinatları haritalandıran bir web sayfasını oluşturur. İşleyişini şu şekilde açıklayabiliriz:

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

    </p>
<br>
Coding by Grusel






    <br>




    <canvas id="canvas" width="800" height="600"></canvas>





    <script>
        // Tarla sınırlarını temsil eden enlem ve boylam koordinatları
        const enlemBoylamKoordinatları = [
            <?php if (isset($formattedCoordinates)) {
    echo $formattedCoordinates;
} ?> 
        ];

        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');

        // Tarla sınırlarını çizmek için işlev
        function drawTarla() {
            const minX = Math.min(...enlemBoylamKoordinatları.map(k => k[1]));
            const minY = Math.min(...enlemBoylamKoordinatları.map(k => k[0]));
            const maxX = Math.max(...enlemBoylamKoordinatları.map(k => k[1]));
            const maxY = Math.max(...enlemBoylamKoordinatları.map(k => k[0]));

            const width = maxX - minX;
            const height = maxY - minY;

            const scale = Math.min(canvas.width / width, canvas.height / height);

            context.beginPath();

            for (let i = 0; i < enlemBoylamKoordinatları.length; i++) {
                const [enlem, boylam] = enlemBoylamKoordinatları[i];
                const x = (boylam - minX) * scale;
                const y = (enlem - minY) * scale;

                if (i === 0) {
                    context.moveTo(x, y);
                } else {
                    context.lineTo(x, y);
                }
            }

            context.closePath();
            context.lineWidth = 2;
            context.strokeStyle = 'black';
            context.stroke();

            const frameWidth = width * scale;
            const frameHeight = height * scale;

            const frameX = (minX - minX) * scale;
            const frameY = (minY - minY) * scale;

            context.beginPath();
            context.rect(frameX, frameY, frameWidth, frameHeight);
            context.lineWidth = 2;
            context.strokeStyle = 'black';
            context.stroke();
        }

        drawTarla();
    </script>

    

























</body>
</html>


