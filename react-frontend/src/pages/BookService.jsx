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
  const [error, setError] = useState('')
  const [success, setSuccess] = useState('')

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    })
  }

  const handleSubmit = (e) => {
    e.preventDefault()
    if (!formData.bikeModel || !formData.bikeNumber || !formData.serviceType || !formData.serviceDescription || !formData.bookingDate || !formData.preferredTime) {
      setError('Please fill all fields')
      return
    }
    if (new Date(formData.bookingDate) < new Date().toDateString()) {
      setError('Select future date')
      return
    }
    // TODO: POST /api/book-service
    console.log('Book service:', formData)
    setSuccess('Service booked! Team will contact you.')
    setTimeout(() => {
      setSuccess('')
      setFormData({bikeModel: '', bikeNumber: '', serviceType: '', serviceDescription: '', bookingDate: '', preferredTime: ''})
    }, 5000)
  }

  return (
    <>
      <Navbar />
      <section className="page-header">
        <div className="container">
          <h1><i className="fas fa-calendar-plus"></i> Book Bike Service</h1>
          <div className="breadcrumb">
            <a href="/user/dashboard">Dashboard</a> / <span>Book Service</span>
          </div>
        </div>
      </section>

      <section className="content-section">
        <div className="container">
          <div style={{display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '30px'}}>
            {/* Form */}
            <div className="form-container">
              <h3 style={{marginBottom: '20px', color: '#0077b6'}}>
                <i className="fas fa-clipboard-list"></i> Service Booking Form
              </h3>

              {error && (
                <div className="alert alert-danger">
                  <i className="fas fa-exclamation-circle"></i> {error}
                </div>
              )}
              {success && (
                <div className="alert alert-success">
                  <i className="fas fa-check-circle"></i> {success}
                </div>
              )}

              <form onSubmit={handleSubmit}>
                {/* Bike Info */}
                <h4 style={{margin: '20px 0 15px', color: '#f77f00'}}>
                  <i className="fas fa-motorcycle"></i> Bike Information
                </h4>

                <div className="form-group">
                  <label><i className="fas fa-bicycle"></i> Bike Model *</label>
                  <input className="form-control" name="bikeModel" value={formData.bikeModel} onChange={handleChange} required />
                </div>

                <div className="form-group">
                  <label><i className="fas fa-tag"></i> Bike Number *</label>
                  <input className="form-control" name="bikeNumber" value={formData.bikeNumber} onChange={handleChange} required />
                </div>

                {/* Service */}
                <h4 style={{margin: '30px 0 15px', color: '#f77f00'}}>
                  <i className="fas fa-tools"></i> Service Details
                </h4>

                <div className="form-group">
                  <label><i className="fas fa-cogs"></i> Service Type *</label>
                  <select className="form-control" name="serviceType" value={formData.serviceType} onChange={handleChange} required>
                    <option value="">Select Type</option>
                    <option value="Regular Service">Regular Service</option>
                    <option value="Repair">Repair</option>
                    <option value="Insurance Claim">Insurance Claim</option>
                    <option value="AC Service">AC Service</option>
                    <option value="Denting & Painting">Denting & Painting</option>
                  </select>
                </div>

                <div className="form-group">
                  <label><i className="fas fa-align-left"></i> Description *</label>
                  <textarea className="form-control" name="serviceDescription" rows="4" value={formData.serviceDescription} onChange={handleChange} placeholder="Describe issues/services needed" required />
                </div>

                {/* Schedule */}
                <h4 style={{margin: '30px 0 15px', color: '#f77f00'}}>
                  <i className="fas fa-calendar-alt"></i> Schedule
                </h4>

                <div style={{display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px'}}>
                  <div className="form-group">
                    <label><i className="fas fa-calendar"></i> Date *</label>
                    <input type="date" className="form-control" name="bookingDate" value={formData.bookingDate} onChange={handleChange} min={new Date().toISOString().split('T')[0]} required />
                  </div>
                  <div className="form-group">
                    <label><i className="fas fa-clock"></i> Time *</label>
                    <select className="form-control" name="preferredTime" value={formData.preferredTime} onChange={handleChange} required>
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
                  <tr><td>Regular Service</td><td style={{textAlign: 'right'}}><strong>₹500-800</strong></td></tr>
                  <tr><td>Repair</td><td style={{textAlign: 'right'}}><strong>Custom</strong></td></tr>
                  <tr><td>AC Service</td><td style={{textAlign: 'right'}}><strong>₹800-1500</strong></td></tr>
                </table>
                <p className="text-muted mt-20" style={{fontSize: '0.9rem'}}>
                  <i className="fas fa-info-circle"></i> Pricing varies based on work
                </p>
              </div>

              <div className="card mt-20">
                <h3 style={{marginBottom: '10px'}}><i className="fas fa-clock"></i> Hours</h3>
                <table>
                  <tr><td>Monday-Saturday</td><td style={{textAlign: 'right'}}>9AM-6PM</td></tr>
                  <tr><td>Sunday</td><td style={{textAlign: 'right'}}>Closed</td></tr>
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
