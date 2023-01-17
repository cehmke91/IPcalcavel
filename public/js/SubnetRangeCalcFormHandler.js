$(function() {

    $('#subnet-range-calc-form').on('submit', function (event) {
        
        event.preventDefault();

        // reset anything from the previous submit first.
        $('.subnet-range-calc-input').css('border-bottom', '1px solid black');
        $('#subnet-range-calc-output').removeClass('error').empty();

        const form = $(this);
        const url = window.location.origin + form.attr('action');

        const data = {
            ip: $("#ip").val()
        };

        $.ajax({
            type: "POST",
            url: url,
            data: data,

            success: function (data) {
                let response = JSON.parse(data);
                let network = '<div> network: ' 
                            + response.network + '.' + response.host
                            + '</div>';
                let first = '<div> first: ' 
                            + response.subnet_range.first
                            + '</div>';
                let last = '<div> last: ' 
                            + response.subnet_range.last
                            + '</div>'; 
                let hosts = '<div> hosts: ' 
                            + response.subnet_range.hosts
                            + '</div>';
                
                $('#subnet-range-calc-output')
                    .append(network)
                    .append(first)
                    .append(last)
                    .append(hosts);
            },

            error: function (data) {
                $('#subnet-range-calc-output')
                    .addClass('error')    
                    .text("ERROR: " + data.responseJSON.message);
                $('.subnet-range-calc-input')
                    .css('border-bottom', '1px solid red');
            }
        });

    });
});