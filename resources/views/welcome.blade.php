<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="text/javascript" src="https://assets.crisp.chat/widget/javascripts/sdk.min.js"></script>

    <script type="text/javascript">
        // Parse query parameters
        document.addEventListener("DOMContentLoaded", function() {
            var urlSearchParams = new URLSearchParams(window.location.search);
            var params = Object.fromEntries(urlSearchParams.entries());

            var ul = document.getElementById("params");

            Object.keys(params).forEach((key) => {
                var li = document.createElement("li");

                li.appendChild(document.createTextNode(`${key}: ${params[key]}`));
                ul.appendChild(li);
            });
        });

        // Expose proxy methods
        function sendEventToWidget() {
            $crisp.forwardEvent("widget", {
                key: "value"
            });
        }

        function closeModal() {
            $crisp.closeModal();
        }
    </script>

    <style>
        body,
        h3 {
            margin: 0;
            padding: 0;
        }

        .widget {
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="widget">
        <h3>Widget modal</h3></br>

        <span>Parameters:</span></br>
        <ul id="params"></ul><br>

        <button onclick="sendEventToWidget()">Send event to widget</button><br><br>
        <button onclick="closeModal()">Close modal</button>
    </div>

    <script type="text/javascript">
        var wesiteId = "{{ config('crisp.website_id') }}"
        console.log({
            wesiteId
        });

        window.$crisp = [];
        window.CRISP_WEBSITE_ID = wesiteId;
        (function() {
            d = document;
            s = d.createElement("script");
            s.src = "https://client.crisp.chat/l.js";
            s.async = 1;
            d.getElementsByTagName("head")[0].appendChild(s);
        })();
    </script>
</body>

</html>
