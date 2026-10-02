'use client'

import { useState } from 'react'
import Navbar from '../components/Navbar.jsx'
import Footer from '../components/Footer.jsx'

const BookService = () => {
  const [formData, setFormData] = useState({
    bikeModel: '',
    bikeNumber: '',
    serviceType: '',
    serviceDescription: '',
    bookingDate: '',
    preferredTime: ''
  })
  const backendUrl = process.env.NEXT_PUBLIC_PHP_BACKEND_URL ?? ''

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    })
  }

  return (
    <>
      <Navbar />
      <section className="page-header">
        <div className="container">
          <h1><i className="fas fa-calendar-plus"></i> Book Bike Service</h1>
          <div className="breadcrumb">
            <a href={`${backendUrl}/user/user_dashboard.php`}>Dashboard</a> / <span>Book Service</span>
          </div>
        </div>
      </section>

      <section className="content-section">
        <div className="container">
          <div className="booking-layout" style={{display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '30px'}}>
            {/* Form */}
            <div className="form-container">
              <h3 style={{marginBottom: '20px', color: 'var(--garage-blue)'}}>
                <i className="fas fa-clipboard-list"></i> Service Booking Form
              </h3>

              <form method="post" action={`${backendUrl}/user/book_service.php`}>
                {/* Bike Info */}
                <h4 style={{margin: '20px 0 15px', color: 'var(--garage-orange)'}}>
                  <i className="fas fa-motorcycle"></i> Bike Information
                </h4>

                <div className="form-group">
                  <label htmlFor="bikeModel"><i className="fas fa-bicycle"></i> Bike Model *</label>
                  <input id="bikeModel" className="form-control" name="bikeModel" value={formData.bikeModel} onChange={handleChange} required />
                </div>

                <div className="form-group">
                  <label htmlFor="bikeNumber"><i className="fas fa-tag"></i> Bike Number *</label>
                  <input id="bikeNumber" className="form-control" name="bikeNumber" value={formData.bikeNumber} onChange={handleChange} required />
                </div>

                {/* Service */}
                <h4 style={{margin: '30px 0 15px', color: 'var(--garage-orange)'}}>
                  <i className="fas fa-tools"></i> Service Details
                </h4>

                <div className="form-group">
                  <label htmlFor="serviceType"><i className="fas fa-cogs"></i> Service Type *</label>
                  <select id="serviceType" className="form-control" name="serviceType" value={formData.serviceType} onChange={handleChange} required>
                    <option value="">Select Type</option>
                    <option value="Regular Service">Regular Service</option>
                    <option value="Repair">Repair</option>
                    <option value="Insurance Claim">Insurance Claim</option>
                    <option value="AC Service">AC Service</option>
                    <option value="Denting & Painting">Denting & Painting</option>
                  </select>
                </div>

                <div className="form-group">
                  <label htmlFor="serviceDescription"><i className="fas fa-align-left"></i> Description *</label>
                  <textarea id="serviceDescription" className="form-control" name="serviceDescription" rows="4" value={formData.serviceDescription} onChange={handleChange} placeholder="Describe issues/services needed" required />
                </div>

                {/* Schedule */}
                <h4 style={{margin: '30px 0 15px', color: 'var(--garage-orange)'}}>
                  <i className="fas fa-calendar-alt"></i> Schedule
                </h4>

                <div style={{display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px'}}>
                  <div className="form-group">
                    <label htmlFor="bookingDate"><i className="fas fa-calendar"></i> Date *</label>
                    <input id="bookingDate" type="date" className="form-control" name="bookingDate" value={formData.bookingDate} onChange={handleChange} min={new Date().toISOString().split('T')[0]} required />
                  </div>
                  <div className="form-group">
                    <label htmlFor="preferredTime"><i className="fas fa-clock"></i> Time *</label>
                    <select id="preferredTime" className="form-control" name="preferredTime" value={formData.preferredTime} onChange={handleChange} required>
                      <option value="">Select Time</option>
                      <option value="09:00">09:00 AM</option>
                      <option value="10:00">10:00 AM</option>
                      <option value="11:00">11:00 AM</option>
                      <option value="14:00">02:00 PM</option>
                      <option value="15:00">03:00 PM</option>
                      <option value="16:00">04:00 PM</option>
                      <option value="17:00">05:00 PM</option>
                    </select>
                  </div>
                </div>

                <button type="submit" className="btn btn-success btn-block mt-20" style={{padding: '15px'}}>
                  <i className="fas fa-calendar-check"></i> Book Service
                </button>
              </form>
            </div>

            {/* Sidebar */}
            <div>
              <div className="card">
                <div className="card-header">
                  <h3><i className="fas fa-rupee-sign"></i> Pricing Guide</h3>
                </div>
                <table style={{width: '100%'}}>
                  <tbody>
                    <tr><td>Regular Service</td><td style={{textAlign: 'right'}}><strong>₹500-800</strong></td></tr>
                    <tr><td>Repair</td><td style={{textAlign: 'right'}}><strong>Custom</strong></td></tr>
                    <tr><td>AC Service</td><td style={{textAlign: 'right'}}><strong>₹800-1500</strong></td></tr>
                  </tbody>
                </table>
                <p className="text-muted mt-20" style={{fontSize: '0.9rem'}}>
                  <i className="fas fa-info-circle"></i> Pricing varies based on work
                </p>
              </div>

              <div className="card mt-20">
                <h3 style={{marginBottom: '10px'}}><i className="fas fa-clock"></i> Hours</h3>
                <table>
                  <tbody>
                    <tr><td>Monday-Saturday</td><td style={{textAlign: 'right'}}>9AM-6PM</td></tr>
                    <tr><td>Sunday</td><td style={{textAlign: 'right'}}>Closed</td></tr>
                  </tbody>
                </table>
              </div>

              <div className="card mt-20">
                <h3 style={{marginBottom: '10px'}}><i className="fas fa-phone"></i> Contact</h3>
                <p>Bike Garage</p>
                <p>123 Service Road</p>
                <p>+91 9876543210</p>
                <p>info@bikegarage.com</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <Footer />
    </>
  );
};

export default BookService;
