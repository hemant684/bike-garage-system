'use client'

import { useState } from 'react'
import Link from 'next/link'
import Navbar from '../components/Navbar.jsx'
import Footer from '../components/Footer.jsx'

const UserDashboard = () => {
  const [stats] = useState({
    totalBookings: 3,
    completedServices: 2,
    pendingServices: 1,
    totalSpent: 2450
  })
  const [bookings] = useState([
    { id: 1, service_type: 'Regular Service', status: 'completed', booking_date: '15 Jan 2024', bike_number: 'MH12AB1234' },
    { id: 2, service_type: 'Repair', status: 'pending', booking_date: '20 Jan 2024', bike_number: 'MH12AB1234' }
  ])
  const [bills] = useState([
    { id: 1, service_type: 'Regular Service', total_amount: 926.50, payment_status: 'paid', date: '15 Jan 2024' }
  ])
  const [user] = useState({
    fullName: 'John Doe',
    email: 'john@example.com',
    phone: '9876543210',
    bikeModel: 'Honda Activa',
    bikeNumber: 'MH12AB1234'
  })
  const [showModal, setShowModal] = useState(false)
  const backendUrl = process.env.NEXT_PUBLIC_PHP_BACKEND_URL ?? ''

  return (
    <>
      <Navbar />
      <section className="page-header">
        <div className="container">
          <h1><i className="fas fa-user-circle"></i> Welcome, {user.fullName}</h1>
        </div>
      </section>

      <section className="content-section">
        <div className="container">
          <div className="alert alert-info">
            Dashboard totals below are preview data.{' '}
            <a href={`${backendUrl}/user/user_dashboard.php`}>Open your live account dashboard</a>
          </div>
          {/* Stats */}
          <div className="dashboard-grid">
            <div className="stat-card">
              <i className="fas fa-calendar-check" style={{fontSize: '2rem', color: 'var(--garage-blue)'}} />
              <h3>{stats.totalBookings}</h3>
              <p>Total Bookings</p>
            </div>
            <div className="stat-card completed">
              <i className="fas fa-check-circle" style={{fontSize: '2rem', color: 'var(--garage-teal)'}} />
              <h3>{stats.completedServices}</h3>
              <p>Completed Services</p>
            </div>
            <div className="stat-card pending">
              <i className="fas fa-clock" style={{fontSize: '2rem', color: 'var(--garage-orange)'}} />
              <h3>{stats.pendingServices}</h3>
              <p>Pending Services</p>
            </div>
            <div className="stat-card revenue">
              <i className="fas fa-rupee-sign" style={{fontSize: '2rem', color: 'var(--garage-red)'}} />
              <h3>₹{stats.totalSpent.toLocaleString()}</h3>
              <p>Total Spent</p>
            </div>
          </div>

          <div className="user-dashboard-layout" style={{display: 'grid', gridTemplateColumns: '2fr 1fr', gap: '30px'}}>
            {/* Main */}
            <div>
              {/* Quick Actions */}
              <div className="card mb-20">
                <div style={{display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '15px'}}>
                  <h3><i className="fas fa-bolt"></i> Quick Actions</h3>
                </div>
                <div style={{display: 'flex', gap: '15px', flexWrap: 'wrap'}}>
                  <Link href="/book-service" className="btn btn-primary">
                    <i className="fas fa-calendar-plus"></i> Book New Service
                  </Link>
                  <a href={`${process.env.NEXT_PUBLIC_PHP_BACKEND_URL ?? ''}/user/view_bill.php`} className="btn btn-success">
                    <i className="fas fa-file-invoice"></i> View Bills
                  </a>
                  <button onClick={() => setShowModal(true)} className="btn btn-outline">
                    <i className="fas fa-user-edit"></i> Edit Profile
                  </button>
                </div>
              </div>

              {/* Bookings Table */}
              <div className="card">
                <h3 style={{marginBottom: '15px'}}><i className="fas fa-list"></i> My Service Bookings</h3>
                <div className="table-container">
                  <table>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Service</th>
                        <th>Bike</th>
                        <th>Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      {bookings.map(booking => (
                        <tr key={booking.id}>
                          <td><strong>#{booking.id}</strong></td>
                          <td>{booking.service_type}</td>
                          <td>{booking.bike_number}</td>
                          <td>{booking.booking_date}</td>
                          <td><span className={`status-badge status-${booking.status}`}>{booking.status}</span></td>
                        </tr>
                      ))}
                      {bookings.length === 0 && (
                        <tr>
                          <td colSpan="5" style={{textAlign: 'center', padding: '40px'}}>
                            <i className="fas fa-motorcycle" style={{fontSize: '4rem', opacity: 0.5}} />
                            <h3>No Bookings Yet</h3>
                            <p>Book your first service!</p>
                            <Link href="/book-service" className="btn btn-primary">Book Now</Link>
                          </td>
                        </tr>
                      )}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            {/* Sidebar */}
            <div>
              {/* Profile */}
              <div className="card">
                <h3 style={{marginBottom: '10px'}}><i className="fas fa-user"></i> My Profile</h3>
                <div style={{textAlign: 'center'}}>
                  <i className="fas fa-user-circle" style={{fontSize: '4rem', color: 'var(--garage-blue)'}} />
                  <h4>{user.fullName}</h4>
                  <p style={{color: 'var(--text-secondary)'}}>{user.email}</p>
                </div>
                <div style={{borderTop: '1px solid var(--dark-border)', paddingTop: '15px', marginTop: '15px'}}>
                  <p><i className="fas fa-phone"></i> {user.phone}</p>
                  <p><i className="fas fa-map-marker-alt"></i> {user.address || 'Not set'}</p>
                  <p><i className="fas fa-motorcycle"></i> {user.bikeModel} ({user.bikeNumber})</p>
                </div>
                <button onClick={() => setShowModal(true)} className="btn btn-outline btn-block mt-20">
                  <i className="fas fa-edit"></i> Edit Profile
                </button>
              </div>

              {/* Recent Bills */}
              <div className="card mt-20">
                <h3 style={{marginBottom: '15px'}}><i className="fas fa-file-invoice-dollar"></i> Recent Bills</h3>
                {bills.map(bill => (
                  <div key={bill.id} style={{padding: '10px 0', borderBottom: '1px solid var(--dark-border)'}}>
                    <div style={{display: 'flex', justifyContent: 'space-between'}}>
                      <div>
                        <strong>{bill.service_type}</strong>
                        <br />
                        <small>{bill.date}</small>
                      </div>
                      <div style={{textAlign: 'right'}}>
                        <strong style={{color: 'var(--garage-teal)'}}>₹{bill.total_amount}</strong>
                        <br />
                        <small className={`status-badge status-${bill.payment_status}`}>{bill.payment_status}</small>
                      </div>
                    </div>
                  </div>
                ))}
                {bills.length === 0 && <p style={{textAlign: 'center', color: 'var(--text-secondary)'}}>No bills yet</p>}
                <a href={`${process.env.NEXT_PUBLIC_PHP_BACKEND_URL ?? ''}/user/view_bill.php`} className="btn btn-outline btn-block mt-20">
                  <i className="fas fa-eye"></i> View All
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Edit Profile Modal */}
      {showModal && (
        <div className="modal" style={{display: 'flex'}}>
          <div className="modal-content">
            <div style={{display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '20px'}}>
              <h3><i className="fas fa-user-edit"></i> Edit Profile</h3>
              <button onClick={() => setShowModal(false)} style={{background: 'none', border: 'none', fontSize: '1.5rem', cursor: 'pointer'}}>&times;</button>
            </div>
            <form method="post" action={`${backendUrl}/user/user_dashboard.php`}>
              <input type="hidden" name="update_profile" value="1" />
              <div className="form-group">
                <label>Full Name</label>
                <input className="form-control" name="full_name" defaultValue={user.fullName} required />
              </div>
              <div className="form-group">
                <label>Phone</label>
                <input className="form-control" name="phone" defaultValue={user.phone} required />
              </div>
              <div className="form-group">
                <label>Bike Model</label>
                <input className="form-control" name="bike_model" defaultValue={user.bikeModel} required />
              </div>
              <div className="form-group">
                <label>Bike Number</label>
                <input className="form-control" name="bike_number" defaultValue={user.bikeNumber} required />
              </div>
              <div className="form-group">
                <label>Address</label>
                <input className="form-control" name="address" defaultValue={user.address ?? ''} />
              </div>
              <button type="submit" className="btn btn-primary btn-block mt-20">
                Save Changes
              </button>
            </form>
          </div>
        </div>
      )}

      <Footer />
    </>
  );
};

export default UserDashboard;
