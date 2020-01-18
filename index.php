<html>

<?php include_once('conn-azure.php'); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> ☕️ Upload Azure Blobs aditya06 </title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="text-center">
        <h1> Upload Azure Blobs here Submission 2! </h1>
        <p> Upload your file Images, then click <strong> Upload </strong> to Azure Blobs Storage.</p>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        Pilih file: <input type="file" name="berkas" />
        <input type="submit" name="upload" value="upload" />
    </form>
    <!-- Azure-Storage Blobs-->
    <h1> Azure Storage Blobs: blobs-azure </h1>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Nama File</th>
                <th>Ukuran File</th>
                <th>URL</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
            do {
                foreach ($result->getBlobs() as $blob) {
            ?>
                    <tr>
                        <td><?php echo $blob->getName() ?></td>
                        <td><?php echo $blob->getProperties()->getContentLength() ?></td>
                        <td><?php echo $blob->getUrl() ?></td>

                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="url" value="<?php echo $blob->getUrl() ?>">
                                <input type="submit" name="submit" value="Lihat">
                            </form>
                        </td>
                    </tr>
            <?php
                }
                $listBlobsOptions->setContinuationToken($result->getContinuationToken());
            } while ($result->getContinuationToken());
            ?>
        </tbody>
    </table>

    <!-- Analisa 2 -->
    <?php
    if (isset($_POST['submit'])) {
        if (isset($_POST['url'])) {
            $url = $_POST['url'];
        } else {
            // header("Location: index.php");
        }
    } else {
        // header("Location: index.php");
    }
    ?>

    <h1> Cognitive Services : Images Analisis </h1>
    <script type="text/javascript">
        $(document).ready(function() {
            var subscriptionKey = "b6eeff8549c742c69264b1644ad5dee0";
            var uriBase = "https://visionaditya06.cognitiveservices.azure.com/vision/v2.0/analyze";

            // Request parameters.
            var params = {
                "visualFeatures": "Categories,Description,Color",
                "details": "",
                "language": "en",
            };

            // Display the image.
            var sourceImageUrl = "<?php echo $url ?>";
            document.querySelector("#sourceImage").src = sourceImageUrl;

            // Make the REST API call.
            $.ajax({
                    url: uriBase + "?" + $.param(params),

                    // Request headers.
                    beforeSend: function(xhrObj) {
                        xhrObj.setRequestHeader("Content-Type", "application/json");
                        xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", subscriptionKey);
                    },
                    type: "POST",

                    // Request body.
                    data: '{"url": ' + '"' + sourceImageUrl + '"}',
                })
                .done(function(data) {

                    // Show formatted JSON on webpage.
                    $("#responseTextArea").val(JSON.stringify(data, null, 2));
                    $("#description").text(data.description.captions[0].text);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {

                    // Display error message.
                    var errorString = (errorThrown === "") ? "Error. " :
                        errorThrown + " (" + jqXHR.status + "): ";
                    errorString += (jqXHR.responseText === "") ? "" :
                        jQuery.parseJSON(jqXHR.responseText).message;
                    alert(errorString);
                });
        });
    </script>
    <br>
    <div id="wrapper" style="width:1020px; display:table;">
        <div id="jsonOutput" style="width:600px; display:table-cell;">
            <b>Response :</b><br><br>
            <textarea id="responseTextArea" class="UIInput" style="width:580px; height:400px;" readonly=""></textarea>
        </div>
        <div id="imageDiv" style="width:420px; display:table-cell;">
            <b>Source Images :</b><br><br>
            <img id="sourceImage" width="300" /><br><br>
            <b>Deskripsi Images :</b>
            <h3 id="description">...</h3>
        </div>
    </div>

</body>

<?php
echo "<pre>";
print_r($_FILES);
echo "</pre>";
?>

</html>