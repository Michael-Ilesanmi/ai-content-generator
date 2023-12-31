<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fill Key Words</title>
</head>
<body>
    <div>
        <h1>media-rich content on any topic based on a specific keyword entered by the user.</h1>
    </div>
    <div>
        <form action="generate.php" method="post">
            <div>
                <label for="keyword">
                    Keyword: 
                    <input type="text" name="keyword" id="keyword" placeholder="example: COVID-19,aviation" required />
                </label>
            </div>
            <div>
                <label for="density">
                    Density Range (min - 1%; max - 20%):
                    <input type="number" value="2" name="min_density" id="min_density" min="1" required>
                    <span>-</span>
                    <input type="number" value="5" name="max_density" id="max_density" max="20" required> %
                </label>
            </div>
            <div>
                <label for="tone">
                    Tone/Style:
                    <select name="tone" id="tone">
                        <option value="narrative">narrative</option>
                        <option value="authoritative">authoritative</option>
                        <option value="sad">sad</option>
                        <option value="emotional">emotional</option>
                        <option value="inspiring">inspiring</option>
                        <option value="professional">professional</option>
                        <option value="happy">happy</option>
                    </select>
                </label>
            </div>
            <br>
            <div>
                <input type="submit" value="Generate Content" />
            </div>
        </form>
    </div>
    <hr>
    <script>
        let keyword = document.querySelector('#keyword');
        let min_density = document.querySelector('#min_density');
        let max_density = document.querySelector('#max_density');
        keyword.addEventListener('keyup', function (e) {
            e.target.value = e.target.value.replace(/ /g, ",");
        })
        min_density.addEventListener('change', function (e) {
            max_density.min = e.target.value;
        })
        max_density.addEventListener('change', function (e) {
            min_density.max = e.target.value;
        })
    </script>
</body>
</html>