import { useState } from 'react'
import Navbar from '../components/Navbar.jsx'
import Footer from '../components/Footer.jsx'

const Login = () => {
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [error, setError] = useState('')

  const handleSubmit = (e) => {
    e.preventDefault()
    // Client validation (validation.js handles)
    if (!email || !password) {
      setError('Please fill all fields')
      return
    }
    // TODO: API call to /api/login.php
    console.log('Login:', { email, password })
    setError('')
    // Redirect to /user/dashboard
  }

  return (
    <>
      <Navbar />
      <section className="page-header">
        <div className="container">
          <h1><i className="fas fa-sign-in-alt"></i> User Login</h1>
          <div className="breadcrumb">
            <a href="/">Home</a> / <span>Login</span>
          </div>
        </div>
      </section>

      <section className="content-section">
        <div className="container">
          <div className="form-container">
            {error && (
              <div className="alert alert-danger">
                <i className="fas fa-exclamation-circle"></i> {error}
              </div>
            )}

            <form id="loginForm" onSubmit={handleSubmit}>
              <div className="form-group">
                <label htmlFor="email">
                  <i className="fas fa-envelope"></i> Email Address
                </label>
                <input 
                  type="email" 
                  className="form-control" 
                  id="email" 
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  placeholder="Enter your email" 
                />
              </div>

              <div className="form-group">
                <label htmlFor="password">
                  <i className="fas fa-lock"></i> Password
                </label>
                <input 
                  type="password" 
                  className="form-control" 
                  id="password" 
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  placeholder="Enter your password"
                />
              </div>

              <div className="form-group">
                <button type="submit" className="btn btn-primary btn-block">
                  <i className="fas fa-sign-in-alt"></i> Login
                </button>
              </div>

              <div className="text-center mt-20">
                <a href="/forgot-password" className="forgot-password">
                  <i className="fas fa-question-circle"></i> Forgot Password?
                </a>
              </div>

              <div className="text-center mt-20" style={{borderTop: '1px solid var(--dark-border)', paddingTop: '20px'}}>
                <p>Don&apos;t have an account? 
                  <a href="/register">
                    <i className="fas fa-user-plus"></i> Register here
                  </a>
                </p>
              </div>
            </form>
          </div>

          {/* Demo Credentials */}
          <div className="form-container mt-20" style={{maxWidth: '500px'}}>
            <h3 className="text-center mb-20"><i className="fas fa-info-circle"></i> Demo Credentials</h3>
            <div className="card">
              <p><strong>Email:</strong> john@example.com</p>
              <p><strong>Password:</strong> user123</p>
              <p className="text-muted mt-20" style={{fontSize: '0.9rem'}}>
                <i className="fas fa-exclamation-triangle"></i> 
                Note: Demo for testing. Backend PHP will handle real auth.
              </p>
            </div>
          </div>
        </div>
      </section>
      <Footer />
    </>
  );
};

export default Login;
