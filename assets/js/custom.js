$(document).ready(function () {
   const $initial = $('input[name="start_initial_setup"]');

   if ($initial.length) {
       startInitialSetup()
   }

    const $information = $('input[name="start_information_setup"]');

    if ($information.length) {
        startInformationSetup();
    }
});

function startInitialSetup() {
    $.ajax({
        method: 'POST',
        url: '/avans-tuindees-installation-gui/public/start-initial-setup',
        success: function () {
            const $button = $('.btn.btn-secondary');
            $button.addClass('btn-success').html('Gelukt!');

            setTimeout(function () {
                window.location.href = "/avans-tuindees-installation-gui/public/information"
            }, 2000);
        },
        error: function (error) {
            alert('Er is iets fout gegaan. Neem alstublieft contact op met de ICT-afdeling')
        }
    })
}

function startInformationSetup() {
    $.ajax({
        method: 'POST',
        url: '/avans-tuindees-installation-gui/public/start-initial-setup',
        success: function () {
            const $button = $('.btn.btn-secondary');
            $button.addClass('btn-success').html('Gelukt!');

            setTimeout(function () {
                window.location.href = "/avans-tuindees-installation-gui/public/done"
            }, 2000);
        },
        error: function (error) {
            alert('Er is iets fout gegaan. Neem alstublieft contact op met de ICT-afdeling')
        }
    })
}