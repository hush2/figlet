<?php
// (C) hush2 <hushywushy@gmail.com>

require 'Figlet.php';

function render($font, $font2, $text) {
    try {
        $font = "flf/$font.flf";
        if (!file_exists($font)) {
            throw new Exception('File not found');
        }
        $figlet = new Text_Figlet();
        $figlet->LoadFont($font);
        $figtext = $figlet->LineEcho($text) ;
        $_SESSION['text'] = $figtext . PHP_EOL;
        $_SESSION['font'] = $font2;
        return $figtext;
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

?>

<!doctype html>
<head>
    <link rel="stylesheet" href="css.css" />
    <title>Figlet ^_^</title>
<head>
<h1>Figlet (C)oded by hush2</h1>
<h3>Create ascii and PNG figlet text.</h3>

<?php
session_start();
if (!isset($_GET['text'])) {
    $text = 'Hello, World';
    $font = 'Georgia11';
    $font2 = 'Aurulent Sans Mono';
} else {
    $text = $_GET['text'];
    $font = $_GET['font'];
    $font2 = $_GET['font2'];
    if (!isset($_SESSION['text'])) {
        echo "<h2 class='error'>** Please enable cookies. **</h2>";
    }
}

?>

<br/>
<form action="/index.php" method="get">
Enter any text: <input type="text" size="30" name="text" value="<?php echo $text ?>">

Ascii Font:
<select name='font'>
<?php
foreach (glob('flf/*.flf') as $file) {
    $file = pathinfo($file);
    $filename = $file['filename'];
    $selected = $font == $filename ? 'selected' : null;
    echo "<option $selected value='$filename'>$filename</option>";
}
?>
</select>

Graphic Font:
<select name='font2'>
<?php
foreach (glob('ttf/*.ttf') as $file) {
    $file = pathinfo($file);
    $filename = $file['filename'];
    $selected = $font2 == $filename ? 'selected' : null;
    echo "<option $selected value='$filename'>$filename</option>";
}
?>
</select>

<input type="submit" value="Go!">
</form>
<br/>
<pre class='text'>
    <?php echo render($font, $font2, $text) ?>
</pre>

<img src="/image.php">
<br/><br/>
<a  href='allfonts.htm'>List all ascii fonts.</a>
