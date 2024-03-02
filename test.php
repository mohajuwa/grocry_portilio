<?php
// Replace these variables with your actual database credentials
$host = 'localhost';
$dbname = 'hiquality';
$user = 'root';
$password = 'modwir';

// Create a PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Connection failed: " . $e->getMessage();
    die();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $category_id = $_POST['category_id'];

    // Common fields
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $quantity = $_POST['quantity'];
    $trending = isset($_POST['trending']) ? 1 : 0;
    $status = isset($_POST['status']) ? 1 : 0;

    // Arabic data
    $nameAr = $_POST['name_ar'];
    $slugAr = $_POST['slug_ar'];
    $brandAr = $_POST['brand_ar'];
    $small_descriptionAr = $_POST['small_description_ar'];
    $descriptionAr = $_POST['description_ar'];
    $meta_titleAr = $_POST['meta_title_ar'];
    $meta_keywordAr = $_POST['meta_keyword_ar'];

    // English data
    $nameEn = $_POST['name_en'];
    $slugEn = $_POST['slug_en'];
    $brandEn = $_POST['brand_en'];
    $small_descriptionEn = $_POST['small_description_en'];
    $descriptionEn = $_POST['description_en'];
    $meta_titleEn = $_POST['meta_title_en'];
    $meta_keywordEn = $_POST['meta_keyword_en'];

    // SQL query to insert data into "productsAr"
    $sqlAr = "INSERT INTO productsAr (category_id, name, slug, brand, small_description, description, meta_title, meta_keyword, status,
               original_price, selling_price, quantity, trending) 
             VALUES ('$category_id', '$nameAr', '$slugAr', '$brandAr', '$small_descriptionAr', '$descriptionAr', '$meta_titleAr', '$meta_keywordAr', '$status',
               '$original_price', '$selling_price', '$quantity', '$trending')";

    // SQL query to insert data into "productsEn"
    $sqlEn = "INSERT INTO productsEn (category_id, name, slug, brand, small_description, description, meta_title, meta_keyword, status,
               original_price, selling_price, quantity, trending) 
             VALUES ('$category_id', '$nameEn', '$slugEn', '$brandEn', '$small_descriptionEn', '$descriptionEn', '$meta_titleEn', '$meta_keywordEn', '$status',
               '$original_price', '$selling_price', '$quantity', '$trending')";

    // Execute the queries
    try {
        $stmtAr = $pdo->prepare($sqlAr);
        $stmtAr->execute();

        $stmtEn = $pdo->prepare($sqlEn);
        $stmtEn->execute();
    } catch (PDOException $e) {
        // Handle query execution errors
        echo "Query failed: " . $e->getMessage();
        die();
    }

    // Redirect after successful submission
    header("Location: test.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Add Product</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <!-- Common Fields -->
            <div class="form-group">
                <label for="category_id">Category ID:</label>
                <input type="text" class="form-control" name="category_id" required>
            </div>

            <div class="form-group">
                <label for="original_price">Original Price:</label>
                <input type="text" class="form-control" name="original_price" required>
            </div>

            <div class="form-group">
                <label for="selling_price">Selling Price:</label>
                <input type="text" class="form-control" name="selling_price" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="text" class="form-control" name="quantity" required>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="trending">
                <label class="form-check-label" for="trending">Trending</label>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="status">
                <label class="form-check-label" for="status">Status</label>
            </div>

            <!-- Arabic Fields -->
            <div class="form-group">
                <label for="name_ar">Arabic Name:</label>
                <input type="text" class="form-control" name="name_ar" required>
            </div>

            <div class="form-group">
                <label for="slug_ar">Arabic Slug:</label>
                <input type="text" class="form-control" name="slug_ar" required>
            </div>

            <div class="form-group">
                <label for="brand_ar">Arabic Brand:</label>
                <input type="text" class="form-control" name="brand_ar">
            </div>

            <div class="form-group">
                <label for="small_description_ar">Arabic Small Description:</label>
                <textarea class="form-control" name="small_description_ar"></textarea>
            </div>

            <div class="form-group">
                <label for="description_ar">Arabic Description:</label>
                <textarea class="form-control" name="description_ar"></textarea>
            </div>

            <div class="form-group">
                <label for="meta_title_ar">Arabic Meta Title:</label>
                <input type="text" class="form-control" name="meta_title_ar">
            </div>

            <div class="form-group">
                <label for="meta_keyword_ar">Arabic Meta Keyword:</label>
                <input type="text" class="form-control" name="meta_keyword_ar">
            </div>

            <!-- English Fields -->
            <div class="form-group">
                <label for="name_en">English Name:</label>
                <input type="text" class="form-control" name="name_en" required>
            </div>

            <div class="form-group">
                <label for="slug_en">English Slug:</label>
                <input type="text" class="form-control" name="slug_en" required>
            </div>

            <div class="form-group">
                <label for="brand_en">English Brand:</label>
                <input type="text" class="form-control" name="brand_en">
            </div>

            <div class="form-group">
                <label for="small_description_en">English Small Description:</label>
                <textarea class="form-control" name="small_description_en"></textarea>
            </div>

            <div class="form-group">
                <label for="description_en">English Description:</label>
                <textarea class="form-control" name="description_en"></textarea>
            </div>

            <div class="form-group">
                <label for="meta_title_en">English Meta Title:</label>
                <input type="text" class="form-control" name="meta_title_en">
            </div>

            <div class="form-group">
                <label for="meta_keyword_en">English Meta Keyword:</label>
                <input type="text" class="form-control" name="meta_keyword_en">
            </div>

            <button type="submit" class="btn btn-success">Add Product</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>

</html>