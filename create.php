<?php 
    $pdo = new PDO('mysql:host=localhost;port=3308;dbname=products_crud', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $ERROR = [];
    $title = '';
    $description = '';
    $prize = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $prize = $_POST['prize'];
        $date = date('Y-m-d H:i:s');

        if (!$title) {                              //error function should be above execution
            $ERROR[] = 'title is required';
        }
        if (!$prize) {
            $ERROR[] = 'prize is required';
        }

        if (empty($ERROR)) {
            $statement = $pdo->prepare("INSERT INTO products (image, title, description, prize, create_date)
                            VALUES (:image, :title, :description, :prize, :date)");
            $statement->bindValue(':image', '');
            $statement->bindValue(':title', $title);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':prize', $prize);
            $statement->bindValue(':date', $date);
            $statement->execute();
        };
    };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>product crud</title>
</head>
<body>
    <h1>Create new item</h1>
    <?php if (!empty($ERROR)) { ?>
        <div class="alert alert-danger">
            <?php foreach ($ERROR as $ERROR) { ?>
                <div><?php echo $ERROR ?></div>
            <?php } ?>
        </div>
    <?php } ?>
    <form action="create.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">image</label>
            <input type="file" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">title</label>
            <input type="text" name="title" value="<?php echo $title ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">description</label>
            <textarea class="form-control" value="<?php $description ?>" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">prize</label>
            <input type="number" class="form-control" step=".01" value="<?php $prize ?>" name="prize">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
</html>