


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


    <hr>
<br>
Coding by constgrusel






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


