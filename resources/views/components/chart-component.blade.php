@props(['datasets' => [
    ['label'=> '',
    'data'=> [1000],
    'borderWidth'=> 1]
], 'labels' => ['528'], 'data' => ['']])

<div {{ $attributes->merge(['class' => '']) }}>
    <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('myChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: @json($datasets),
        fill: false,
        backgroundColor: 'rgb(25, 25, 112)',
        borderColor:'rgb(25, 25, 112)',
        tension: 0.1
    },
    options: {
    }
});
</script>
