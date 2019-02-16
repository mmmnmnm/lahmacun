<!-- RADIO code -->

<?php
/*
server
if local - boerek
else lahmacun - lahmacun

then echo
*/

$development = "http://dev.lahmacun.hu:8083/";
$main = "https://www.lahmacun.hu:8084/"; 
$localServer = $_SERVER['REMOTE_ADDR'];

if ( in_array( $_SERVER['SERVER_NAME'], array( 'dev.lahmacun.hu') ) ) { 
	$broadcastServer = "https://dev.lahmacun.hu:8084/";
} else {
	$broadcastServer = "https://www.lahmacun.hu:8084/";
}

// echo "<h1>".$broadcastServer."</h1>";
 
?>

<script type="text/javascript">
	var streamServer = "<?php echo $broadcastServer ?>";
</script>

<link rel="stylesheet" type="text/css" href="<?php echo $broadcastServer ?>static/js/bootgrid/jquery.bootgrid.min.css" />

<link rel="stylesheet" type="text/css" href="<?php echo $broadcastServer ?>static/dist/light-cec2eee1b0.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" crossorigin="anonymous" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js" crossorigin="anonymous" integrity="sha256-1Q2q5hg2YXp9fYlM++sIEXOcUb8BRSDUsQ1zXvLBqmA="></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js" crossorigin="anonymous" integrity="sha256-EGs9T1xMHdvM1geM8jPpoo8EZ1V1VRsmcJz8OByENLA="></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js" crossorigin="anonymous" integrity="sha256-xaF9RpdtRxzwYMWg4ldJoyPWqyDPCRD0Cv7YEEe6Ie8="></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.js" crossorigin="anonymous" integrity="sha256-ICvFZLf7gslwfpvdxzQ8w8oZt0brzoFr8v2dXBecuLY=" defer></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.min.js" crossorigin="anonymous" integrity="sha256-LlN0a0J3hMkDLO1mhcMwy+GIMbIRV7kvKHx4oCxNoxI=" defer></script>

<script type="text/javascript" src="<?php echo $broadcastServer ?>static/js/bootgrid/jquery.bootgrid.updated.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/store.js/1.3.20/store.min.js" crossorigin="anonymous" integrity="sha256-0jgHNEQo7sIScbcI/Pc5GYJ+VosKM1mJ+fI0iuQ1a9E=" defer></script>


<div class="page-minimal station-lahmacun_radio">

<script type="text/javascript" nonce="BQ4A2ZdmNz1kbMfKQl0nVf6H">

var nowPlaying;

function iterateTimer() {
    var np_elapsed = nowPlaying.np.now_playing.elapsed;
    var np_total = nowPlaying.np.now_playing.duration;

    if (np_elapsed < np_total) {
        nowPlaying.np.now_playing.elapsed = np_elapsed + 1;
    }
}

function formatTime(time) {
    var sec_num = parseInt(time, 10);

    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours < 10) {
        hours = "0" + hours;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    return (hours !== "00" ? hours + ':' : "") + minutes + ':' + seconds;
}

$(function() {
    nowPlaying = new Vue({
        el: '#station-nowplaying',
        data: {"np":{ "live":{"is_live":"Is Live","streamer_name":"Streamer Name"},
                      "now_playing":
                      {"song":{"title":"Song Title","artist":"Song Artist","art":"https://www.lahmacun.hu:8084/api/station/1/art/bc6f2c7ed9ca958d13d8bb55.jpg"},"is_request":false,"elapsed":0,"duration":0}
                    }
              },
        computed: {
            "time_display": function() {
                var time_played = this.np.now_playing.elapsed;
                var time_total = this.np.now_playing.duration;

                if (!time_total) {
                    return null;
                }

                if (time_played > time_total) {
                    time_played = time_total;
                }

                return formatTime(time_played) + ' / ' + formatTime(time_total);
            },
            "show_title": function() {
              if (this.np.live.is_live)
                return this.np.live.streamer_name
              else
                return this.np.now_playing.song.title
            }
        }
    });

    setInterval(iterateTimer, 1000);
});
</script>
<script type="text/javascript" nonce="BQ4A2ZdmNz1kbMfKQl0nVf6H">
$(function() {

    songHistory = new Vue({
        el: '#station-history',
        data: {
            history: [
                {
                    song: {
                        title: 'Song Title',
                        artist: 'Song Artist'
                    }
                }
            ]
        }
    });

    function loadNowPlaying() {
        $.getJSON( streamServer + 'api/nowplaying/1', function(row) {
            nowPlaying.np = row;
            songHistory.history = row.song_history;

            if ('mediaSession' in navigator) {
                navigator.mediaSession.metadata = new MediaMetadata({
                    title: row.now_playing.song.title,
                    artist: row.now_playing.song.artist,
                    artwork: [
                        { src: row.now_playing.song.art }
                    ]
                });
            }

            setTimeout(loadNowPlaying, 15000);
        }).fail(function() {
            setTimeout(loadNowPlaying, 30000);
        });
    }
    loadNowPlaying();

/* 
    $('[data-fancybox]').fancybox({
        buttons: ['close']
    });
 */

	var request_dialog = $('#modal-request');

	request_dialog.on('show.bs.modal', function (event) {

		if (!request_dialog.data('request_loaded'))
		{
			var grid = $("#requests-table").bootgrid({
				ajax: true,
				rowSelect: false,
				caseSensitive: false,
				url: "/api/station/1/requests",
				formatters: {
					"commands": function(column, row) {
						return '<a class="btn btn-request btn-sm btn-primary" data-url="'+row.request_url+'">Request</a>';
					}
				}
			}).on("loaded.rs.jquery.bootgrid", function()
			{
				/* Executes after data is loaded and rendered */
				grid.find(".btn-request").on("click", function(e)
				{
					e.preventDefault();
					request_dialog.modal('hide');

					$.ajax({
						dataType: "json",
						url: $(this).data('url')
					}).done(function(data) {
						notify(data, 'success');
					}).fail(function(jqXhr) {
						notify('Error: ' + jqXhr.responseJSON, 'danger');
					});

					return false;
				});
			});

			request_dialog.data('request_loaded', true);
		}

	});
});
</script>


<div class="public-page">
    <div class="card">
        <div class="card-body">


            <div class="stations nowplaying altalanosinfok">
                <div class="media media-left" id="station-nowplaying">
    <div class="pull-left pr-2 pt-3">
        <a class="btn-audio" role="button" title="Play/Pause" href="#" data-url="<?php echo $broadcastServer ?>radio/8000/radio.mp3?1543513066" >
            <i class="material-icons lg">play_circle_outline</i>
        </a>
    </div>
    <div class="pull-left pr-2" v-if="np.now_playing.song.art">
        <a v-bind:href="np.now_playing.song.art" data-fancybox target="_blank" class="swipebox" ><img v-bind:src="np.now_playing.song.art" alt="Album Cover" style="width: 50px; height: auto; border-radius: 5px;"></a>
    </div>
    <div class="media-body">
        <h4 class="media-heading might-overflow nowplaying-title">
            {{ show_title }}
        </h4>
        <div class="nowplaying-artist might-overflow">
            {{ np.now_playing.song.artist }}
        </div>
    </div>
</div>
            </div>

            <div class="radio-controls-standalone volumecontrolos" id="radio-player-controls">
                <a href="javascript:;" class="text-secondary jp-mute" title="Mute">
                    <i class="material-icons">volume_mute</i>
                </a>
                <input type="range" title="Volume" class="d-inline-block custom-range jp-volume-range" style="" id="jp-volume-range" min="0" max="100" step="1">
                <a href="javascript:;" class="text-secondary jp-volume-full" title="Full Volume">
                    <i class="material-icons">volume_up</i>
                </a>
            </div>

        </div>
        <div class="player-wrap creditswrap">
        <a href="schedule.pdf" target="_blank">Schedule</a> | <a href="lahmacun.m3u" target="_blank">Stream</a> | <a href="mailto:lahmacun@mmmnmnm.com" target="_blank">Contact</a>
        </div>

    </div>

</div>




</div>

<!-- RADIO code -->