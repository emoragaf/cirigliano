<?php
/**
 * Copyright 2012 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Follow the instructions on https://github.com/google/google-api-php-client
 * to download, extract and include the Google APIs client library for PHP into
 * your project.
 */
session_start();

/**
 * Visit https://console.developers.google.com to generate your
 * oauth2_client_id, oauth2_client_secret, and to register your
 * oauth2_redirect_uri.
 */
//Yii::import('webroot.vendor.google.apiclient.src.Google.Service.Storage');
$client = new Google_Client();
$client->setApplicationName('Google Cloud Storage PHP Starter Application');
$client->setClientId('918514686129-unb1ttadoeosclsf7nue2mm1jj59ao8n.apps.googleusercontent.com');
$client->setClientSecret('PS3zQUePDuB3M1fOamoXtI3B');
$client->setRedirectUri('http://localhost:8888/cirigliano/site/gstore');
$client->setDeveloperKey('AIzaSyCn3gIPc4OdBOxikZPM7SWdMiEOa91r9Pg');
$client->setScopes('https://www.googleapis.com/auth/devstorage.full_control');
$storageService = new Google_Service_Storage($client);

/**
 * Constants for sample request parameters.
 */
define('API_VERSION', 'v1');
define('DEFAULT_PROJECT', 'soy-envelope-701');
define('DEFAULT_BUCKET', 'fotos-cirigliano');
define('DEFAULT_OBJECT', 'Captura de pantalla 2014-09-12 12.09.44.png');

/**
 * Generates the markup for a specific Google Cloud Storage API request.
 * @param string $apiRequestName The name of the API request to process.
 * @param string $apiResponse The API response to process.
 * @return string Markup for the specific Google Cloud Storage API request.
 */
function generateMarkup($apiRequestName, $apiResponse) {
  $apiRequestMarkup = '';
  $apiRequestMarkup .= "<header><h2>" . $apiRequestName . "</h2></header>";
  if ($apiResponse['items'] == '' ) {
    $apiRequestMarkup .= "<pre>";
    $apiRequestMarkup .= print_r(json_decode(json_encode($apiResponse), true),
      true);
    $apiRequestMarkup .= "</pre>";
  } else {
    foreach($apiResponse['items'] as $response) {
      $apiRequestMarkup .= "<pre>";
      $apiRequestMarkup .= print_r(json_decode(json_encode($response), true),
        true);
      $apiRequestMarkup .= "</pre>";
    }
  }

  return $apiRequestMarkup;
}

/**
 * Clear access token whenever a logout is requested.
 */
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

/**
 * Authenticate and set client access token.
 */
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

/**
 * Set client access token.
 */
if (isset($_SESSION['access_token'])) {
  $client->setAccessToken($_SESSION['access_token']);
}

/**
 * If all authentication has been successfully completed, make Google
 * Cloud Storage API requests.
 */
if ($client->getAccessToken()) {
  /**
   * Google Cloud Storage API request to retrieve the list of buckets in your
   * Google Cloud Storage project.
   */
  $buckets = $storageService->buckets->listBuckets(DEFAULT_PROJECT);
  $listBucketsMarkup = generateMarkup('List Buckets', $buckets);

  /**
   * Google Cloud Storage API request to retrieve the list of objects in your
   * Google Cloud Storage bucket.
   */
  $objects = $storageService->objects->listObjects(DEFAULT_BUCKET);
  $listObjectsMarkup = generateMarkup('List Objects', $objects);

  /**
   * Google Cloud Storage API request to retrieve the list of Access Control
   * Lists on your Google Cloud Storage buckets.
   */
  $bucketsAccessControls = $storageService->bucketAccessControls->
    listBucketAccessControls(DEFAULT_BUCKET);
  $listBucketsAccessControlsMarkup = generateMarkup('List Buckets Access Controls', $bucketsAccessControls);

  /**
   * Google Cloud Storage API request to retrieve the list of Access Control
   * Lists on your Google Cloud Storage objects.
   */
  $objectsAccessControls = $storageService->objectAccessControls->
    listObjectAccessControls(DEFAULT_BUCKET, DEFAULT_OBJECT);
  $listObjectsAccessControlsMarkup = generateMarkup('List Objects Access Controls', $objectsAccessControls);

  /**
   * Google Cloud Storage API request to retrieve a bucket from your
   * Google Cloud Storage project.
   */
  $bucket = $storageService->buckets->get(DEFAULT_BUCKET);
  $getBucketMarkup = $bucket;//generateMarkup('Get Bucket', $bucket);

  // The access token may have been updated lazily.
  $_SESSION['access_token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
}
?>
    <header><h1>Google Cloud Storage Sample App</h1></header>
    <div class="main-content">
      <?php if(isset($listBucketsMarkup)): ?>
        <div id="listBuckets">
          <?php print_r($listBucketsMarkup) ?>
        </div>
      <?php endif ?>
      <br><br>
      <?php if(isset($listObjectsMarkup)): ?>
        <div id="listObjects">
          <?php print_r($listObjectsMarkup) ?>
        </div>
      <?php endif ?>
      <br><br>
      <?php if(isset($listBucketsAccessControlsMarkup)): ?>
        <div id="listBucketsAccessControls">
          <?php print_r($listBucketsAccessControlsMarkup) ?>
        </div>
      <?php endif ?>
      <br><br>
      <?php if(isset($listObjectsAccessControlsMarkup)): ?>
        <div id="listObjectsAccessControls">
          <?php print_r($listObjectsAccessControlsMarkup)?>
        </div>
      <?php endif ?>
      <br><br>
      <?php if(isset($getBucketMarkup)): ?>
        <div id="getBucket">
          <?php print_r($getBucketMarkup) ?>
        </div>
      <?php endif ?>
      <br><br>
      <?php
        if(isset($authUrl)) {
          print "<a class='login' href='$authUrl'>Authorize Me!</a>";
        } else {
          print "<a class='logout' href='?logout'>Logout</a>";
        }
      ?>
    </div>