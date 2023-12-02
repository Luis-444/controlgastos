@props(['datasets' => [[
    'label' => 'My First Dataset',
    'data' => [300],
    'backgroundColor'=> [
        'rgb(173, 216, 230)',
    ],
    'hoverOffset' => 4
]], 'labels' => ['Categoria1'], 'data' => ['']])

<div {{ $attributes->merge(['class' => '']) }}>
    <canvas class="w-full" id="myDoughnutChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctxDoughnut = document.getElementById('myDoughnutChart');

    new Chart(ctxDoughnut, {
      type: 'doughnut',
      data: {
        labels: @json($labels),
        datasets: @json($datasets),
      },
      options: {
        weight: 1,
      }
    });
</script>
