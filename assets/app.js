/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import { Chart as ChartJS, ArcElement, Tooltip, LinearScale } from 'chart.js';
ChartJS.register(ArcElement, Tooltip, LinearScale);

document.addEventListener('prices_loaded', function () {
    let pricesData = JSON.parse(document.getElementById('prices-table').getAttribute('data-json-prices'));
    var barCount = pricesData.length;
    var initialDateStr = pricesData[pricesData.length - 1].formattedDate;

    var ctx = document.getElementById('prices_chart').getContext('2d');
    ctx.canvas.width = 1000;
    ctx.canvas.height = 250;

    var chart = new ChartJS(ctx, {
        type: 'candlestick',
        data: {
            datasets: [{
                label: 'CHRT - Chart.js Corporation',
                data: pricesData.map(function (price) {
                    return {
                        x: Date.parse(price.fromattedDate),
                        o: price.open,
                        h: price.high,
                        l: price.low,
                        c: price.close
                    }
                })
            }]
        }
    });

    var update = function() {
        var dataset = chart.config.data.datasets[0];
        dataset.type = 'candlestick';
        chart.config.options.scales.y.type = 'linear';
        var defaultOpts = ChartJS.defaults.elements['candlestick'];
        dataset.borderColor = defaultOpts.borderColor;

        chart.config.data.datasets = [
            {
                label: 'CHRT - Chart.js Corporation',
                data: pricesData.map(function (price) {
                    return {
                        x: price.formattedDate,
                        o: price.open,
                        h: price.high,
                        l: price.low,
                        c: price.close
                    }
                })
            }
        ]


        chart.update();
    };
})
