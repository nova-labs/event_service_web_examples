    var url = "https://event.nova-labs.org/events/novalabs_space/latest";

    function eventToStatus(event) {
        var status = { "id": 0, "text": "UNKNOWN", "classes": "btn btn-warning", "time": new Date(0), "icon": "https://www.nova-labs.org/images/nova-labs_icon_120x120.png"};
        if (event == null || event === undefined) {
        } else {
            if (event.value == "open") {
                status.id = 1;
                status.text = "OPEN";
                status.classes = "btn btn-success";
                status.icon = "https://www.nova-labs.org/images/nova-labs_icon_120x120.png";
            } else if (event.value == "closed") {
                status.id = 0;
                status.text = "CLOSED";
                status.classes = "btn btn-danger";
                status.icon = "https://www.nova-labs.org/images/nova-labs_icon_off_120x120.png";
            }
            status.time = new Date(event.epochMillis);
        }
        return status;
    }

    function formatDate(date) {
        return jQuery.formatDateTime('D yy-mm-dd gg:ii:ss.uu a', date);
    }

    function formatShortDate(date) {
        return jQuery.formatDateTime('M dd hh:ii', date);
    }

    jQuery( document ).ready(function() {
        jQuery.getJSON(url, function( event ) {
            var status = eventToStatus(event);
            var dateTime = formatDate(status.time);
            var shortDateTime = formatShortDate(status.time);
            jQuery("#state_text").html(status.text);
            jQuery("#state_button_xsm").html(status.text).removeClass().addClass(status.classes);
            jQuery("#state_button_sm").html(status.text + "<br/>" + shortDateTime).removeClass().addClass(status.classes);
            jQuery("#state_button_lg").html(status.text + "<br/>" + dateTime).removeClass().addClass(status.classes);

            jQuery("#state_icon").attr("src", status.icon);
            jQuery("#state_icon_sm").attr("src", status.icon);
            jQuery("#state_icon_bug").attr("src", status.icon);
            jQuery("#state_icon_header").attr("src", status.icon);

            jQuery("#state_json").html(JSON.stringify(event, null, 4));
        });
    });
