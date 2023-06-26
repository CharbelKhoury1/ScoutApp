function showOptions(id) {
  document.getElementById(id).style.display = 'block';
}

function hideOptions(id) {
  document.getElementById(id).style.display = 'none';
}

function fetchBalance() {
  fetch('../controllers/balanceController.php')
      .then(response => response.json())
      .then(data => {

        const chartContainerLBP = document.getElementById('chartContainerLBP');
        const chartContainerUSD = document.getElementById('chartContainerUSD');
        chartContainerLBP.innerHTML = ''; // Clear previous content
        chartContainerUSD.innerHTML = ''; // Clear previous content

          const balanceTextLBP = document.createElement('div');
          balanceTextLBP.innerHTML = `<h3 class="balance-text">Current Balance: ${data.lbp_balance} LBP</h3>`;
          chartContainerLBP.appendChild(balanceTextLBP);
          document.getElementById('chartContainerLBP').insertBefore(balanceTextLBP, document.getElementById('chartLBP'));

          const chartLBP = document.createElement('canvas');
          chartLBP.id = 'chartLBP';
          chartContainerLBP.appendChild(chartLBP);

          const balanceTextUSD = document.createElement('div');
          balanceTextUSD.innerHTML = `<h3 class="balance-text">Current Balance: ${data.usd_balance} USD</h3>`;
          document.getElementById('chartContainerUSD').insertBefore(balanceTextUSD, document.getElementById('chartUSD'));
          
          const chartUSD = document.createElement('canvas');
          chartUSD.id = 'chartUSD';
          chartContainerUSD.appendChild(chartUSD);

          const chartDataLBP = {
              labels: ['LBP Income', 'LBP Expense'],
              datasets: [{
                  data: [data.lbp_income, data.lbp_expense],
                  backgroundColor: ['#007bff', '#dc3545'],
              }]
          };

          new Chart(chartLBP, {
              type: 'doughnut',
              data: chartDataLBP,
              options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  legend: {
                      position: 'bottom'
                  },
                  plugins: {
                      title: {
                          display: true,
                          text: 'LBP Income and Expenses'
                      }
                  }
              }
          });

          const chartDataUSD = {
              labels: ['USD Income', 'USD Expense'],
              datasets: [{
                  data: [data.usd_income, data.usd_expense],
                  backgroundColor: ['#007bff', '#dc3545'],
              }]
          };

          new Chart(chartUSD, {
              type: 'doughnut',
              data: chartDataUSD,
              options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  legend: {
                      position: 'bottom'
                  },
                  plugins: {
                      title: {
                          display: true,
                          text: 'USD Income and Expenses'
                      }
                  }
              }
          }); 
      });
}