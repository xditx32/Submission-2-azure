<?php
require_once 'vendor/autoload.php';
require_once "./random_string.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

//connect_to_azure
$connectionString = "DefaultEndpointsProtocol=https;AccountName=storageaditya06;AccountKey=kJagjglaSU0rmQo2tI7RJWO+Oxn5fGO3oQSXWQZzYV/3WpcoXHC3wo/Tvg9XB5ZwZmIK/Kg5bCyzJw+LiWcEGg==;EndpointSuffix=core.windows.net";
// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);
// $fileToUpload = "HelloWorld.txt";
$containerName = "blobs-azure";

if (isset($_POST['upload'])) {

    $fileToUpload = $_FILES["berkas"]["name"];
    $content = fopen($_FILES["berkas"]["tmp_name"], "r");
    echo fread($content, filesize($fileToUpload));

    $blobClient->createBlockBlob($containerName, $fileToUpload, $content);
    header("Location: index.php");
}

$listBlobsOptions = new ListBlobsOptions();
$listBlobsOptions->setPrefix("");
$result = $blobClient->listBlobs($containerName, $listBlobsOptions);

// Upload_and_clear_storage
// if (!isset($_GET["Cleanup"])) {
// // Create container options object.
// $createContainerOptions = new CreateContainerOptions();

// // Set public access policy. Possible values are
// // PublicAccessType::CONTAINER_AND_BLOBS and PublicAccessType::BLOBS_ONLY.
// // CONTAINER_AND_BLOBS:
// // Specifies full public read access for container and blob data.
// // proxys can enumerate blobs within the container via anonymous
// // request, but cannot enumerate containers within the storage account.
// //
// // BLOBS_ONLY:
// // Specifies public read access for blobs. Blob data within this
// // container can be read via anonymous request, but container data is not
// // available. proxys cannot enumerate blobs within the container via
// // anonymous request.
// // If this value is not specified in the request, container data is
// // private to the account owner.
// $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

// // Set container metadata.
// $createContainerOptions->addMetaData("key1", "value1");
// $createContainerOptions->addMetaData("key2", "value2");

// // $containerName = "blobs".generateRandomString();
// $containerName = "blobs-azure";


// try {
//         // Create container.
//         $blobClient->createContainer($containerName, $createContainerOptions);

//         // Getting local file so that we can upload it to Azure
//         $myfile = fopen($fileToUpload, "r") or die("Unable to open file!");
//         fclose($myfile);

//         # Upload file as a block blob
//         echo "Uploading BlockBlob: ".PHP_EOL;
//         echo $fileToUpload;
//         echo "<br />";

//         $content = fopen($fileToUpload, "r");

//         //Upload blob
//         $blobClient->createBlockBlob($containerName, $fileToUpload, $content);

//         // List blobs.
//         $listBlobsOptions = new ListBlobsOptions();
//         $listBlobsOptions->setPrefix("HelloWorld");

//         echo "These are the blobs present in the container: ";

// do {
//     $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
//     foreach ($result->getBlobs() as $blob)
//     {
//     echo $blob->getName().": ".$blob->getUrl()."<br />";
//     }

//     $listBlobsOptions->setContinuationToken($result->getContinuationToken());
// } while($result->getContinuationToken());
//     echo "<br />";

// // Get blob.
// echo "This is the content of the blob uploaded: ";
//     $blob = $blobClient->getBlob($containerName, $fileToUpload);
// fpassthru($blob->getContentStream());
//     echo "<br />";
// } catch(ServiceException $e){
//     // Handle exception based on error codes and messages.
//     // Error codes and messages are here:
//     // http://msdn.microsoft.com/library/azure/dd179439.aspx
//     $code = $e->getCode();
//     $error_message = $e->getMessage();
//         echo $code.": ".$error_message."<br />";
//     } catch(InvalidArgumentTypeException $e){
// // Handle exception based on error codes and messages.
// // Error codes and messages are here:
// // http://msdn.microsoft.com/library/azure/dd179439.aspx
//     $code = $e->getCode();
//     $error_message = $e->getMessage();
//         echo $code.": ".$error_message."<br />";
//     }
// } else {
//     try{
//         // Delete container.
//         echo "Deleting Container".PHP_EOL;
//         echo $_GET["containerName"].PHP_EOL;
//         echo "<br />";
//         $blobClient->deleteContainer($_GET["containerName"]);
//     }
//     catch(ServiceException $e){
//         // Handle exception based on error codes and messages.
//         // Error codes and messages are here:
//         // http://msdn.microsoft.com/library/azure/dd179439.aspx
//         $code = $e->getCode();
//         $error_message = $e->getMessage();
//         echo $code.": ".$error_message."<br />";
//     }
// }
