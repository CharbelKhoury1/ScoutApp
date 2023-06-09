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
          const balanceTextLBP = document.createElement('div');
          balanceTextLBP.innerHTML = `<h3 class="balance-text">Current Balance: ${data.lbp_balance} LBP</h3>`;
          document.getElementById('chartContainerLBP').insertBefore(balanceTextLBP, document.getElementById('chartLBP'));

          const balanceTextUSD = document.createElement('div');
          balanceTextUSD.innerHTML = `<h3 class="balance-text">Current Balance: ${data.usd_balance} USD</h3>`;
          document.getElementById('chartContainerUSD').insertBefore(balanceTextUSD, document.getElementById('chartUSD'));

          const chartDataLBP = {
              labels: ['LBP Income', 'LBP Expense'],
              datasets: [{
                  data: [data.lbp_income, data.lbp_expense],
                  backgroundColor: ['#007bff', '#dc3545'],
              }]
          };

          const chartContainerLBP = document.getElementById('chartContainerLBP');
          chartContainerLBP.style.display = 'block'; // Display the LBP chart container

          const chartLBP = document.getElementById('chartLBP').getContext('2d');
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

          const chartContainerUSD = document.getElementById('chartContainerUSD');
          chartContainerUSD.style.display = 'block'; // Display the USD chart container

          const chartUSD = document.getElementById('chartUSD').getContext('2d');
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