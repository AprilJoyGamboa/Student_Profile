<?php
include_once("db.php");
include_once("student.php");

$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);

$data = $student->getGenderData();
$data2 = $student->getPopulationData();
$data3 = $student->getBirthYearData();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <!-- Include the header -->
    <?php include('includes/navbar.php'); ?>
    <div class="content">

                            <div class="search-container">
                                <input type="text" class="search-bar" placeholder="Search...">
                                <button class="search-button">Search</button>
                            </div>
                            
                            <div class="dashboard-title">Number of Students Enrolled</div>
                            
                            <div class="col-md-5">
                                <div class="card ">
                                    <div class="content">
                                    <canvas id="student_gender" width="250" height="200"></canvas>
                                    <canvas id="townres" width="250" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
<div class="content">
    <div class="flex">
        <div class="card-body">
            <h2>Gender Percentage Report</h2>
            <hr>
            <canvas id="genderPie" width="250" height="250"></canvas>
        </div>
        <div class="card-body">
            <h2>Population Report</h2>
            <hr>
            <canvas id="populationChart" width="350" height="350"></canvas>
        </div>
    </div>
    <div class="card-body-2">
        <h2>Students Birth Year Report</h2>
        <hr>
        <canvas id="yearLine" height="100"></canvas>
    </div>
</div>
</body>
<?php include('templates/footer.html'); ?>
</html>

<!--Scripts-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    var labels = [];
    var counts = [];

    <?php foreach ($data as $item): ?>
    labels.push('<?php echo $item["gender"] === "0" ? "Male" : "Female"; ?>');
    counts.push(<?php echo $item["count"]; ?>);
    <?php endforeach; ?>

    const gender = document.getElementById('genderPie').getContext('2d');
    const polarAreaChart = new Chart(gender, {
                type: 'polarArea',
                data: {
                    labels: labels,
                    datasets: [{
                        data: counts,
                        backgroundColor: ['#FF69B4', '#FF7F50']

            }]
        },
        options: {
            title: {
                display: true,
                text: 'Gender Percentage'
            }
        }
    });
</script>

<script>
    var labels = [];
    var datasets = {};

    <?php foreach ($data2 as $item): ?>
    var province = '<?php echo $item["province_name"]; ?>';
    var townCity = '<?php echo $item["town_name"]; ?>';
    var count = <?php echo $item["count"]; ?>;

    labels.push(townCity);

    if (!datasets[province]) {
        datasets[province] = [];
    }
    datasets[province].push(count);
    <?php endforeach; ?>

    const population = document.getElementById('populationChart').getContext('2d');
    const barChart = new Chart(population, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: Object.keys(datasets).map(province => ({
                label: province,
                data: datasets[province],
                backgroundColor: getRandomColor(),
            }))
        },
        options: {
            title: {
                display: true,
                text: 'Population Percentage by Town/City'
            },
            scales: {
                x: { stacked: false },
                y: { stacked: false }
            }
        }
    });
</script>

<script>
    var labels = [];
    var counts = [];

    <?php foreach ($data3 as $item): ?>
    labels.push(<?php echo $item["birth_year"]; ?>);
    counts.push(<?php echo $item["count"]; ?>);
    <?php endforeach; ?>

    const totalStudents = counts.reduce((total, count) => total + count, 0);
    const percentages = counts.map(count => (count / totalStudents) * 100);

    const birthChart = document.getElementById('yearLine').getContext('2d');
    const doughnutChart = new Chart(birthChart, {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            label: 'Birth Year Percentage',
            data: percentages,
            backgroundColor: [
  'rgba(255, 99, 132, 0.2)',
  'rgba(255, 159, 64, 0.2)',
  'rgba(255, 205, 86, 0.2)',
  'rgba(75, 192, 192, 0.2)',
  'rgba(54, 162, 235, 0.2)',
  'rgba(153, 102, 255, 0.2)',
  'rgba(201, 203, 207, 0.2)'
],
             borderColor: [
  'rgb(255, 99, 132)',
  'rgb(255, 159, 64)',
  'rgb(255, 205, 86)',
  'rgb(75, 192, 192)',
  'rgb(54, 162, 235)',
  'rgb(153, 102, 255)',
  'rgb(201, 203, 207)',
],
            fill: true
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Birth Year Percentage Chart'
            },
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                    title: {
                        display: true,
                        text: 'Birth Year'
                    }
                },
                y: {
                    min: 0,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Percentage'
                    }
                }
            }
        }
    });
    console.log(labels);
    console.log(datasets);
</script>
