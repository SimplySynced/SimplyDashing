var today = moment().format('YYYY-MM-DD');
var clientId = '968293514399-vdtb6b6nua7p3cohr7lrd6ls41vg0jp5.apps.googleusercontent.com';
var apiKey = 'AIzaSyCDcU--4KSVLCHpC7nlnJZOMnFPL3dzbLg';
var scopes = 'https://www.googleapis.com/auth/calendar';

function handleClientLoad() {
    gapi.client.setApiKey(apiKey);
    window.setTimeout(checkAuth,1);
}

function checkAuth() {
    gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
}

function handleAuthResult(authResult) {
    var authorizeButton = document.getElementById('authorize-button');

    if (authResult && !authResult.error) {
        authorizeButton.style.visibility = 'hidden';
        makeApiCall();
    } else {
        authorizeButton.style.visibility = '';
        authorizeButton.onclick = handleAuthClick;
        //GeneratePublicCalendar();
    }
}

function handleAuthClick(event) {
    gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
    return false;
}

// Load the API and make an API call.  Display the results on the screen.
function makeApiCall() {

    // Step 4: Load the Google+ API
    gapi.client.load('calendar', 'v3').then(function() {
        // Step 5: Assemble the API request
        var request = gapi.client.calendar.events.list({
            'calendarId': 'simplysyncedllc@gmail.com'
        });

        // Step 6: Execute the API request
        request.then(function(resp) {

            var events = [];
            var successArgs;
            var successRes;

            if (resp.result.error) {
                reportError('Google Calendar API: ' + data.error.message, data.error.errors);
            }
            else if (resp.result.items) {
                $.each(resp.result.items, function(i, entry) {
                    var url = entry.htmlLink;

                    // make the URLs for each event show times in the correct timezone
                    //if (timezoneArg) {
                    //    url = injectQsComponent(url, 'ctz=' + timezoneArg);
                    //}

                    events.push({
                        id: entry.id,
                        title: entry.summary,
                        start: entry.start.dateTime || entry.start.date, // try timed. will fall back to all-day
                        end: entry.end.dateTime || entry.end.date, // same
                        url: url,
                        location: entry.location,
                        description: entry.description
                    });
                });

                // call the success handler(s) and allow it to return a new events array
                successArgs = [ events ].concat(Array.prototype.slice.call(arguments, 1)); // forward other jq args
                successRes = $.fullCalendar.applyAll(true, this, successArgs);
                if ($.isArray(successRes)) {
                    return successRes;
                }
            }

            if(events.length > 0)
            {
                $('#calendar').fullCalendar({
                    header: false,
                    selectable: true,
                    // customize the button names,
                    // otherwise they'd all just say "list"
                    defaultView: 'listDay',
                    defaultDate: today,
                    navLinks: false, // can click day/week names to navigate views
                    editable: false,
                    eventLimit: true, // allow "more" link when too many events

                    eventClick:  function(event, jsEvent, view) {
                        if (event.url) {
                            $(this).find('a').attr('href', '#');
                            var startTime = moment(event.start).format('h:mm A');
                            $('.start').html(startTime);
                            var endTime = moment(event.end).format('h:mm A');
                            $('.end').html(endTime);
                            if (startTime == endTime) {
                                $('#time').html('All Day Event');
                            }
                            $('#modalTitle').html(event.title);
                            $('#eventDesc').html(event.description);
                            $('#eventURL').html('<a target="new" href="' + event.url + '">View Event');
                            $('#calendarModal').modal();
                            return false
                        }

                    },

                });

            }

            return events;

        }, function(reason) {
            console.log('Error: ' + reason.result.error.message);
        });
    });

}