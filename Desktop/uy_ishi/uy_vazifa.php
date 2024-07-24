<!DOCTYPE html>
<html lang="uz">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .txt {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <form action="index.php" method="POST">
        <div>ish vaqti 8:00 dan</div> <br>
        <div>ish vaqti 17:00 gacha</div> <br><br>
        <h1 class="txt">Ma'lumot kiriting....</h1>
        <div class="row g-3">
            <div class="col-sm-4">
                <input type="date" id="sana" name="sana" class="form-control">
            </div>
            <div class="col-sm">
                <input type="time" id="kelgan_vaqt" name="kelgan_vaqt" class="form-control">
            </div>
            <div class="col-sm">
                <input type="time" id="ketgan_vaqt" name="ketgan_vaqt" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Yuborish</button>
        <br>
    </form>

    <?php
    try {
        $pdo = new PDO("mysql:host=localhost;port=3306;dbname=first_database", 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sana = $_POST['sana'];
            $kelgan_vaqt = $_POST['kelgan_vaqt'];
            $ketgan_vaqt = $_POST['ketgan_vaqt'];
            $ishlangan_soat = date('H:i', strtotime($ketgan_vaqt) - strtotime($kelgan_vaqt));

            $ish_vaqti = 9 * 60 * 60; 
            $real_ishlangan_vaqt = strtotime($ketgan_vaqt) - strtotime($kelgan_vaqt);
            $qarz_vaqt = date('H:i', $ish_vaqti - $real_ishlangan_vaqt);

            $stmt = $pdo->prepare("INSERT INTO Shonazarov (sana, kelgan_vaqt, ketgan_vaqt, ishlagan_soat, qarz_vaqt) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$sana, $kelgan_vaqt, $ketgan_vaqt, $ishlangan_soat, $qarz_vaqt]);
        }

        class Day
        {
            private $pdo;

            public function __construct($pdo)
            {
                $this->pdo = $pdo;
            }

            public function work()
            {
                $query = $this->pdo->query("SELECT * FROM Shonazarov");
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        $day = new Day($pdo);
        $results = $day->work();
    } catch (PDOException $e) {
        echo "Ulanishda xatolik: " . $e->getMessage();
    }
    ?>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">SANA</th>
                <th scope="col">KELGAN VAQT</th>
                <th scope="col">KETGAN VAQT</th>
                <th scope="col">ISHLAGAN SOAT</th>
                <th scope="col">QARZ VAQT</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($results)) : ?>
                <?php foreach ($results as $row) : ?>
                    <tr>
                        <th scope="row"><?php echo $row['ID']; ?></th>
                        <td><?php echo $row['sana']; ?></td>
                        <td><?php echo $row['kelgan_vaqt']; ?></td>
                        <td><?php echo $row['ketgan_vaqt']; ?></td>
                        <td><?php echo $row['ishlagan_soat']; ?></td>
                        <td><?php echo $row['qarz_vaqt']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
