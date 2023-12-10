$(document).ready(() => {

    $("#eventGame").keydown((e) => {

        var query = e.target.value;

        if (query.length > 0) {

            $.ajax({
                url: "https://meetoplay.duckdns.org/index.php?m=game&f=getGamesName",
                method: "get",
                data: { gameNameInput: e.target.value }

            }).done((html) => {
                $("#gameList").html(html);
            });
        }
    });

});