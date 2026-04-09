import { useState } from 'react'
import Navbar from '../components/Navbar.jsx'
import Footer from '../components/Footer.jsx'

const Register = () => {
  const [formData, setFormData] = useState({
    fullName: '',
    email: '',
    phone: '',
    address: '',
    bikeModel: '',
    bikeNumber: '',
    password: '',
    confirmPassword: ''
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
    // Client validation
    if (!formData.fullName || !formData.email || !formData.phone || !formData.bikeModel || !formData.bikeNumber || !formData.password) {
      setError('Please fill required fields')
      return
    }
    if (formData.password !== formData.confirmPassword) {
      setError('Passwords do not match')
      return
    }
    // TODO: API /api/register.php
    console.log('Register:', formData)
    setError('')
    setSuccess('Registration successful! Redirecting to login...')
  }

  return (
    <>
      <Navbar />
      <section className="page-header">
        <div className="container">
          <h1><i className="fas fa-user-plus"></i> User Registration</h1>
          <div className="breadcrumb">
            <a href="/">Home</a> / <span>Register</span>
          </div>
        </div>
      </section>

      <section className="content-section">
        <div className="container">
          <div className="form-container" style={{maxWidth: '600px'}}>
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

            <form id="registerForm" onSubmit={handleSubmit}>
              {/* Personal */}
              <h3 style={{marginBottom: '20px', color: 'var(--garage-blue)'}}>
                <i className="fas fa-user"></i> Personal Information
              </h3>
              
              <div className="form-group">
                <label htmlFor="fullName">
                  <i className="fas fa-user"></i> Full Name *
                </label>
                <input type="text" className="form-control" id="fullName" name="fullName" 
                  value={formData.fullName} onChange={handleChange}
                  placeholder="Enter your full name" />
              </div>

              <div className="form-group">
                <label htmlFor="email">
                  <i className="fas fa-envelope"></i> Email Address *
                </label>
                <input type="email" className="form-control" id="email" name="email" 
                  value={formData.email} onChange={handleChange}
                  placeholder="Enter your email" />
              </div>

              <div className="form-group">
                <label htmlFor="phone">
                  <i className="fas fa-phone"></i> Phone Number *
                </label>
                <input type="tel" className="form-control" id="phone" name="phone" 
                  value={formData.phone} onChange={handleChange}
                  placeholder="10-digit mobile number" />
              </div>

              <div className="form-group">
                <label htmlFor="address">
                  <i className="fas fa-map-marker-alt"></i> Address
                </label>
                <textarea className="form-control" id="address" name="address" rows="2" 
                  value={formData.address} onChange={handleChange}
                  placeholder="Enter your address" />
              </div>

              {/* Bike */}
              <h3 style={{margin: '30px 0 20px', color: 'var(--garage-blue)'}}>
                <i className="fas fa-motorcycle"></i> Bike Information
              </h3>

              <div className="form-group">
                <label htmlFor="bikeModel">
                  <i className="fas fa-bicycle"></i> Bike Model *
                </label>
                <input type="text" className="form-control" id="bikeModel" name="bikeModel" 
                  value={formData.bikeModel} onChange={handleChange}
                  placeholder="e.g., Honda Activa" />
              </div>

              <div className="form-group">
                <label htmlFor="bikeNumber">
                  <i className="fas fa-tag"></i> Bike Number *
                </label>
                <input type="text" className="form-control" id="bikeNumber" name="bikeNumber" 
                  value={formData.bikeNumber} onChange={handleChange}
                  placeholder="e.g., MH12AB1234" />
              </div>

              {/* Password */}
              <h3 style={{margin: '30px 0 20px', color: 'var(--garage-blue)'}}>
                <i className="fas fa-lock"></i> Account Security
              </h3>

              <div className="form-group">
                <label htmlFor="password">
                  <i className="fas fa-lock"></i> Password *
                </label>
                <input type="password" className="form-control" id="password" name="password" 
                  value={formData.password} onChange={handleChange}
                  placeholder="At least 6 chars + letter/number" />
              </div>

              <div className="form-group">
                <label htmlFor="confirmPassword">
                  <i className="fas fa-lock"></i> Confirm Password *
                </label>
                <input type="password" className="form-control" id="confirmPassword" name="confirmPassword" 
                  value={formData.confirmPassword} onChange={handleChange}
                  placeholder="Re-enter password" />
              </div>

              <div className="form-group">
                <div className="checkbox" style={{display: 'flex', alignItems: 'center', gap: '10px'}}>
                  <input type="checkbox" id="terms" name="terms" required />
                  <label htmlFor="terms" style={{margin: 0}}>
                    I agree to Terms and Conditions and Privacy Policy
                  </label>
                </div>
              </div>

              <div className="form-group">
                <button type="submit" className="btn btn-success btn-block">
                  <i className="fas fa-user-plus"></i> Register
                </button>
              </div>

              <div className="text-center mt-20" style={{borderTop: '1px solid var(--dark-border)', paddingTop: '20px'}}>
                <p>Already have account? <a href="/login"><i className="fas fa-sign-in-alt"></i> Login</a></p>
              </div>
            </form>
          </div>
        </div>
      </section>
      <Footer />
    </>
  );
};

export default Register;
