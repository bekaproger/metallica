//got this script from https://github.com/chartjs/chartjs-chart-financial/blob/master/docs/index.js
function buildChart(pricesData) {

    var ctx = document.getElementById('prices_chart').getContext('2d');
    ctx.canvas.width = 1000;
    ctx.canvas.height = 250;

    var barData = formatPrices(pricesData);

    new Chart(ctx, {
        type: 'candlestick',
        data: {
            datasets: [{
                label: 'Prices chart',
                data: barData
            }]
        }
    });

    function formatPrices(prices) {
        let formattedPrices = [];

        prices.forEach(function (price) {
            formattedPrices.unshift({
                x: luxon.DateTime.fromSQL(price.formattedDate).valueOf(),
                o: price.open,
                h: price.high,
                l: price.low,
                c: price.close
            });
        });

        return formattedPrices;
    }
}

window.onload = function () {

    let jsonData = JSON.parse(document.getElementById('prices-table').getAttribute('data-json-prices'))

    if (jsonData && jsonData.length > 0) {
        buildChart(jsonData)
    }

}
