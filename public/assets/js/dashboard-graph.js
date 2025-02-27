const orderTrendsChart = echarts.init(document.getElementById('orderTrends'));
const orderTrendsOption = {
    animation: false,
    grid: {
        top: 20,
        right: 20,
        bottom: 20,
        left: 40
    },
    xAxis: {
        type: 'category',
        data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        axisLine: {
            lineStyle: {
                color: '#E5E7EB'
            }
        }
    },
    yAxis: {
        type: 'value',
        axisLine: {
            lineStyle: {
                color: '#E5E7EB'
            }
        }
    },
    series: [{
        data: [150, 230, 224, 218, 135, 147, 260],
        type: 'line',
        smooth: true,
        symbol: 'none',
        lineStyle: {
            color: 'rgba(87, 181, 231, 1)'
        },
        areaStyle: {
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: 'rgba(87, 181, 231, 0.3)'
            }, {
                offset: 1,
                color: 'rgba(87, 181, 231, 0.1)'
            }])
        }
    }]
};
orderTrendsChart.setOption(orderTrendsOption);
const topProductsChart = echarts.init(document.getElementById('topProducts'));
const topProductsOption = {
    animation: false,
    tooltip: {
        trigger: 'item'
    },
    series: [{
        type: 'pie',
        radius: ['40%', '70%'],
        itemStyle: {
            borderRadius: 8
        },
        label: {
            show: true,
            formatter: '{b}: {c} ({d}%)'
        },
        data: [{
                value: 1048,
                name: 'Headphones'
            },
            {
                value: 735,
                name: 'Smartphones'
            },
            {
                value: 580,
                name: 'Laptops'
            },
            {
                value: 484,
                name: 'Tablets'
            }
        ],
        color: ['rgba(87, 181, 231, 1)', 'rgba(141, 211, 199, 1)', 'rgba(251, 191, 114, 1)', 'rgba(252, 141, 98, 1)']
    }]
};
topProductsChart.setOption(topProductsOption);
window.addEventListener('resize', () => {
    orderTrendsChart.resize();
    topProductsChart.resize();
});
