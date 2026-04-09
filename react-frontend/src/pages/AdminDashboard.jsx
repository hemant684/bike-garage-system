import { useState, useEffect } from 'react'
import Navbar from '../components/Navbar.jsx'
import Footer from '../components/Footer.jsx'

const AdminDashboard = () => {
  const [stats, setStats] = useState({
    totalUsers: 0,
    totalBookings: 0,
    pendingServices: 0,
    completedServices: 0,
    totalRevenue: 0,
    todayBookings: 0
  })
  const [monthlyRevenue, setMonthlyRevenue] = useState(Array(12).fill(0))
  const [statusDistribution, setStatusDistribution] = useState({})
  const [recentBookings, setRecentBookings] = useState([])
  const [recentUsers, setRecentUsers] = useState([])
  const [recentBills, setRecentBills] = useState([])

  // Mock data (replace with API)
  useEffect(() => {
    setStats({
      totalUsers: 25,
      totalBookings: 150,
      pendingServices: 12,
      completedServices: 120,
      totalRevenue: 125000,
      todayBookings: 5
    })
    setMonthlyRevenue([5000, 8000, 12000, 15000, 18000, 22000, 20000, 25000, 28000, 30000, 32000, 35000])
    setStatusDistribution({
      pending: 12,
      approved: 8,
      'in_progress': 25,
      completed: 95,
      cancelled: 10
    })
    setRecentBookings([
      { full_name: 'John Doe', bike_model: 'Honda Activa', service_type: 'Regular Service', status: 'completed' },
      { full_name: 'Jane Smith', bike_model: 'Royal Enfield', service_type: 'Repair', status: 'pending' }
    ])
    setRecentUsers([
      { full_name: 'New User', bike_model: 'Bajaj Pulsar', created_at: '2024-01-10' }
    ])
    setRecentBills([
      { id: 123, full_name: 'John Doe', service_type: 'Regular Service', total_amount: 926.50, payment_status: 'paid' }
    ])
  }, [])

  const exportData = () => {
    const data = { stats, monthlyRevenue, statusDistribution }
    const blob = new Blob([JSON.stringify(data, null, 2)], {type: 'application/json'})
    const url = URL.createObjectURL(blob)
    const a = document.createElement('a')
    a.href = url
    a.download = 'admin-data.json'
    a.click()
  }

  const getStatusColor = (status) => {
    const colors = {
      pending: '#f77f00',
      approved: '#00b4d8',
      'in_progress': '#fcbf49',
      completed: '#2a9d8f',
      cancelled: '#e63946'
    }
    return colors[status] || '#666'
  }

  const totalBookings = Object.values(statusDistribution).reduce((a, b) => a + b, 0)

  return (
    <>
      <Navbar />
      <div className="dashboard-header">
        <div className="container">
          <h1><i className="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
          <p>Welcome back, Admin! Here's what's happening.</p>
          <div className="welcome-badge">
            <i className="fas fa-calendar-alt"></i> {new Date().toLocaleDateString('en-GB', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}
          </div>
        </div>
      </div>

      <section className="content-section">
        <div className="container">
          {/* Stats */}
          <div className="stats-grid">
            <div className="stat-box users">
              <div className="icon"><i className="fas fa-users"></i></div>
              <div className="number">{stats.totalUsers.toLocaleString()}</div>
              <div className="label">Total Users</div>
            </div>
            <div className="stat-box bookings">
              <div className="icon"><i className="fas fa-calendar-check"></i></div>
              <div className="number">{stats.totalBookings.toLocaleString()}</div>
              <div className="label">Total Bookings</div>
            </div>
            <div className="stat-box pending">
              <div className="icon"><i className="fas fa-clock"></i></div>
              <div className="number">{stats.pendingServices}</div>
              <div className="label">Pending</div>
            </div>
            <div className="stat-box completed">
              <div className="icon"><i className="fas fa-check-circle"></i></div>
              <div className="number">{stats.completedServices}</div>
              <div className="label">Completed</div>
            </div>
            <div className="stat-box revenue">
              <div className="icon"><i className="fas fa-rupee-sign"></i></div>
              <div className="number">₹{stats.totalRevenue.toLocaleString()}</div>
              <div className="label">Revenue</div>
            </div>
            <div className="stat-box today">
              <div className="icon"><i className="fas fa-calendar-day"></i></div>
              <div className="number">{stats.todayBookings}</div>
              <div className="label">Today</div>
            </div>
          </div>

          {/* Quick Actions */}
          <div className="quick-actions">
            <a href="/manage-bookings" className="action-btn">
              <i className="fas fa-tasks"></i>
              <span>Bookings</span>
            </a>
            <a href="/reports" className="action-btn">
              <i className="fas fa-chart-bar"></i>
              <span>Reports</span>
            </a>
            <button onClick={exportData} className="action-btn">
              <i className="fas fa-download"></i>
              <span>Export</span>
            </button>
          </div>

          {/* Charts */}
          <div className="charts-grid">
            {/* Revenue Chart */}
            <div className="chart-card">
              <h3><i className="fas fa-chart-bar"></i> Monthly Revenue</h3>
              <div className="bar-chart">
                {monthlyRevenue.map((revenue, i) => {
                  const height = revenue / Math.max(...monthlyRevenue) * 150
                  const months = ['J','F','M','A','M','J','J','A','S','O','N','D']
                  return (
                    <div key={i} className="bar" style={{height: height + 'px'}}>
                      <span className="value">₹{revenue.toLocaleString()}</span>
                      <span>{months[i]}</span>
                    </div>
                  )
                })}
              </div>
            </div>

            {/* Status */}
            <div className="chart-card">
              <h3><i className="fas fa-chart-pie"></i> Status Distribution</h3>
              <div className="status-bars">
                {Object.entries(statusDistribution).map(([status, count]) => {
                  const percentage = totalBookings ? (count / totalBookings * 100).toFixed(1) : 0
                  return (
                    <div key={status} className="status-bar-item">
                      <div className="label">{status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}</div>
                      <div className="bar-container">
                        <div className="bar-fill" style={{width: percentage + '%', background: getStatusColor(status)}}>
                          {percentage}%
                        </div>
                      </div>
                      <div className="count">{count}</div>
                    </div>
                  )
                })}
              </div>
            </div>
          </div>

          {/* Tables */}
          <div className="section-grid">
            <div className="section-card">
              <div className="section-header">
                <h3><i className="fas fa-list"></i> Recent Bookings</h3>
                <a href="#" className="view-all">View All →</a>
              </div>
              <table className="data-table">
                <thead>
                  <tr>
                    <th>User</th>
                    <th>Bike</th>
                    <th>Service</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  {recentBookings.map(booking => (
                    <tr key={booking.id}>
                      <td>
                        <div className="user-info">
                          <div className="user-avatar">{booking.full_name.charAt(0)}</div>
                          <div>
                            <div>{booking.full_name}</div>
                            <small>{booking.email}</small>
                          </div>
                        </div>
                      </td>
                      <td>{booking.bike_model}</td>
                      <td>{booking.service_type}</td>
                      <td><span className={`status-badge status-${booking.status}`}>{booking.status}</span></td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
            <div className="section-card">
              <div className="section-header">
                <h3><i className="fas fa-users"></i> New Users</h3>
                <a href="#" className="view-all">View All →</a>
              </div>
              <table className="data-table">
                <thead>
                  <tr>
                    <th>User</th>
                    <th>Bike</th>
                    <th>Joined</th>
                  </tr>
                </thead>
                <tbody>
                  {recentUsers.map(user => (
                    <tr key={user.id}>
                      <td>
                        <div className="user-info">
                          <div className="user-avatar">{user.full_name.charAt(0)}</div>
                          <div>
                            <div>{user.full_name}</div>
                            <small>{user.email}</small>
                          </div>
                        </div>
                      </td>
                      <td>{user.bike_model}</td>
                      <td>{new Date(user.created_at).toLocaleDateString()}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>

          {/* Bills */}
          <div className="section-card">
            <div className="section-header">
              <h3><i className="fas fa-file-invoice"></i> Recent Bills</h3>
            </div>
            <table className="data-table">
              <thead>
                <tr>
                  <th>Bill ID</th>
                  <th>User</th>
                  <th>Service</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                {recentBills.map(bill => (
                  <tr key={bill.id}>
                    <td>BILL-{bill.id}</td>
                    <td>{bill.full_name}</td>
                    <td>{bill.service_type}</td>
                    <td>₹{bill.total_amount}</td>
                    <td><span className={`status-badge status-${bill.payment_status}`}>{bill.payment_status}</span></td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </section>
      <Footer />
    </>
  );
};

export default AdminDashboard;
