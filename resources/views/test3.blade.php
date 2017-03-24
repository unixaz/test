@extends('layouts.app')

<style>
    #channel-image {
        width: 2em;
        height: 2em;
        vertical-align: middle;
    }

    #channel-name {
        margin-left: 0.2em;
        margin-right: 0.2em;
    }

    #disclaimer {
        font-size: 0.75em;
        color: #aeaeae;
        max-width: 350px;
    }

    body {
        font-family: "Open Sans", sans-serif;
        font-size: 1.5em;
    }

    .post-sign-in {
        display: none;
    }

    .during-upload {
        display: none;
    }

    .post-upload {
        display: none;
    }

    label {
        display: block;
    }

    input[type="text"], textarea, progress {
        font-size: 0.75em;
        width: 15em;
        margin-bottom: 1em;
        padding: 0.5em;
        font-family: "Open Sans", sans-serif;
    }

    textarea {
        height: 7em;
    }
</style>



@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> Video kėlimas
                    </div>
                    <div class="panel-body">

                        <span id="signinButton" class="pre-sign-in">
                              <!-- IMPORTANT: Replace the value of the <code>data-clientid</code>
                                   attribute in the following tag with your project's client ID. -->
                              <span
                                      class="g-signin"
                                      data-callback="signinCallback"
                                      data-clientid="733664914176-av3k29o10v3d07n7dvr7bt4nic7mn3p3.apps.googleusercontent.com"
                                      data-cookiepolicy="single_host_origin"
                                      data-scope="https://www.googleapis.com/auth/youtube.upload https://www.googleapis.com/auth/youtube">
                              </span>
                            </span>

                                    <div class="post-sign-in">
                                        <div class="form-group">
                                            <label for="channel-thumbnail">YouTube kanalas:</label><br>
                                            <img id="channel-thumbnail">
                                            <span id="channel-name"></span>
                                        </div>
                                            <hr>
                                        <div class="form-group">
                                            <label for="title">Pavadinimas:</label>
                                            <input type="text" class="form-control" id="title" placeholder="Video pavadinimas">
                                        </div>
										<div class="form-group">
                                            <label for="tags">Raktažodžiai:</label>
                                            <input type="text" class="form-control" id="tags" placeholder="Video raktažodžiai">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Aprašymas:</label>
                                            <textarea class="form-control" id="description" rows="3" placeholder="Video aprašymas"></textarea>
                                        </div>

                                        <div>
                                            <label class="btn btn-default btn-file">
                                                <input type="file" id="file" accept="video/*" hidden>
                                            </label>
                                            <button id="button" type="button" class="btn btn-primary">Įkelti video</button>
                                            <div class="during-upload">
                                                <p><span id="percent-transferred"></span>% įkelta (<span id="bytes-transferred"></span>/<span id="total-bytes"></span> baitų)</p>
                                                <progress id="upload-progress" max="1" value="0"></progress>
                                            </div>

                                            <div class="post-upload">
                                                <p>Įkeltas video kurio id <span id="video-id"></span>. Polling for status...</p>
                                                <ul id="post-upload-status"></ul>
                                                <div id="player"></div>
                                            </div>
                                            <p id="disclaimer">By uploading a video, you certify that you own all rights to the content or that you are authorized by the owner to make the content publicly available on YouTube, and that it otherwise complies with the YouTube Terms of Service located at <a href="http://www.youtube.com/t/terms" target="_blank">http://www.youtube.com/t/terms</a></p>
                                        </div>
                                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//apis.google.com/js/client:plusone.js"></script>
<script src="https://cdn.rawgit.com/youtube/api-samples/master/javascript/cors_upload.js"></script>


<script>
    /*
     Copyright 2015 Google Inc. All Rights Reserved.

     Licensed under the Apache License, Version 2.0 (the "License");
     you may not use this file except in compliance with the License.
     You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

     Unless required by applicable law or agreed to in writing, software
     distributed under the License is distributed on an "AS IS" BASIS,
     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     See the License for the specific language governing permissions and
     limitations under the License.
     */

    var signinCallback = function (result){
        if(result.access_token) {
            var uploadVideo = new UploadVideo();
            uploadVideo.ready(result.access_token);
        }
    };

    var STATUS_POLLING_INTERVAL_MILLIS = 60 * 1000; // One minute.


    /**
     * YouTube video uploader class
     *
     * @constructor
    */
    var UploadVideo = function() {
        /**
         * The array of tags for the new YouTube video.
         *
         * @attribute tags
         * @type Array.<string>
         * @default ['google-cors-upload']
         */
        this.tags = ['youtube-cors-upload'];

        /**
         * The numeric YouTube
         * [category id](https://developers.google.com/apis-explorer/#p/youtube/v3/youtube.videoCategories.list?part=snippet&regionCode=us).
         *
         * @attribute categoryId
         * @type number
         * @default 22
         */
        this.categoryId = 22;

        /**
         * The id of the new video.
         *
         * @attribute videoId
         * @type string
         * @default ''
         */
        this.videoId = '';

        this.uploadStartTime = 0;
    };


    UploadVideo.prototype.ready = function(accessToken) {
        this.accessToken = accessToken;
        this.gapi = gapi;
        this.authenticated = true;
        this.gapi.client.request({
            path: '/youtube/v3/channels',
            params: {
                part: 'snippet',
                mine: true
            },
            callback: function(response) {
                if (response.error) {
                    console.log(response.error.message);
                } else {
                    $('#channel-name').text(response.items[0].snippet.title);
                    $('#channel-thumbnail').attr('src', response.items[0].snippet.thumbnails.default.url);

                    $('.pre-sign-in').hide();
                    $('.post-sign-in').show();
                }
            }.bind(this)
        });
        $('#button').on("click", this.handleUploadClicked.bind(this));
    };

    /**
     * Uploads a video file to YouTube.
     *
     * @method uploadFile
     * @param {object} file File object corresponding to the video to upload.
     */
    UploadVideo.prototype.uploadFile = function(file) {
        var metadata = {
            snippet: {
                title: $('#title').val(),
                description: $('#description').text(),
                tags: this.tags,
                categoryId: this.categoryId
            },
            status: {
                // privacyStatus: $('#privacy-status option:selected').text()
                privacyStatus: 'public'
            }
        };
        var uploader = new MediaUploader({
            baseUrl: 'https://www.googleapis.com/upload/youtube/v3/videos',
            file: file,
            token: this.accessToken,
            metadata: metadata,
            params: {
                part: Object.keys(metadata).join(',')
            },
            onError: function(data) {
                var message = data;
                // Assuming the error is raised by the YouTube API, data will be
                // a JSON string with error.message set. That may not be the
                // only time onError will be raised, though.
                try {
                    var errorResponse = JSON.parse(data);
                    message = errorResponse.error.message;
                } finally {
                    alert(message);
                }
            }.bind(this),
            onProgress: function(data) {
                var currentTime = Date.now();
                var bytesUploaded = data.loaded;
                var totalBytes = data.total;
                // The times are in millis, so we need to divide by 1000 to get seconds.
                var bytesPerSecond = bytesUploaded / ((currentTime - this.uploadStartTime) / 1000);
                var estimatedSecondsRemaining = (totalBytes - bytesUploaded) / bytesPerSecond;
                var percentageComplete = ((bytesUploaded * 100) / totalBytes).toFixed(2);

                $('#upload-progress').attr({
                    value: bytesUploaded,
                    max: totalBytes
                });

                $('#percent-transferred').text(percentageComplete);
                $('#bytes-transferred').text(bytesUploaded);
                $('#total-bytes').text(totalBytes);

                $('.during-upload').show();
            }.bind(this),
            onComplete: function(data) {
                var uploadResponse = JSON.parse(data);
                this.videoId = uploadResponse.id;
                $('#video-id').text(this.videoId);
                $('.post-upload').show();
                this.pollForVideoStatus();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "POST",
                    url: 'http://baka.enxas.eu/upload_data',
                    data: {tags: document.getElementById("tags").value,
					title: document.getElementById("title").value,
					description: document.getElementById("description").value,
					video_id: this.videoId},
                    dataType: 'JSON',
                    success: function( msg ) {
                        console.log('pavyko');
                    }
                });
            }.bind(this)
        });
        // This won't correspond to the *exact* start of the upload, but it should be close enough.
        this.uploadStartTime = Date.now();
        uploader.upload();
    };

    UploadVideo.prototype.handleUploadClicked = function() {
        $('#button').attr('disabled', true);
        this.uploadFile($('#file').get(0).files[0]);
    };

    UploadVideo.prototype.pollForVideoStatus = function() {
        this.gapi.client.request({
            path: '/youtube/v3/videos',
            params: {
                part: 'status,player',
                id: this.videoId
            },
            callback: function(response) {
                if (response.error) {
                    // The status polling failed.
                    console.log(response.error.message);
                    setTimeout(this.pollForVideoStatus.bind(this), STATUS_POLLING_INTERVAL_MILLIS);
                } else {
                    var uploadStatus = response.items[0].status.uploadStatus;
                    switch (uploadStatus) {
                        // This is a non-final status, so we need to poll again.
                        case 'uploaded':
                            $('#post-upload-status').append('<li>Upload status: ' + uploadStatus + '</li>');
                            setTimeout(this.pollForVideoStatus.bind(this), STATUS_POLLING_INTERVAL_MILLIS);
                            break;
                        // The video was successfully transcoded and is available.
                        case 'processed':
                            $('#player').append(response.items[0].player.embedHtml);
                            $('#post-upload-status').append('<li>Final status.</li>');
                            break;
                        // All other statuses indicate a permanent transcoding failure.
                        default:
                            $('#post-upload-status').append('<li>Transcoding failed.</li>');
                            break;
                    }
                }
            }.bind(this)
        });
    };

</script>

