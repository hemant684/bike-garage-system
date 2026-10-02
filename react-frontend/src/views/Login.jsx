import Navbar from '../components/Navbar.jsx'
import Link from 'next/link'
import Footer from '../components/Footer.jsx'

const Login = () => {
  const backendUrl = process.env.NEXT_PUBLIC_PHP_BACKEND_URL ?? ''

  return (
    <>
      <Navbar />
      <section className="page-header">
        <div className="container">
          <h1><i className="fas fa-sign-in-alt"></i> User Login</h1>
          <div className="breadcrumb">
            <Link href="/">Home</Link> / <span>Login</span>
          </div>
        </div>
      </section>

      <section className="content-section">
        <div className="container">
          <div className="form-container">
            <form id="loginForm" method="post" action={`${backendUrl}/login.php`}>
              <div className="form-group">
                <label htmlFor="email">
                  <i className="fas fa-envelope"></i> Email Address
                </label>
                <input 
                  type="email" 
                  className="form-control" 
                  id="email" 
                  name="email"
                  placeholder="Enter your email" 
                  required
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
                  name="password"
                  placeholder="Enter your password"
                  required
                />
              </div>

              <div className="form-group">
                <button type="submit" className="btn btn-primary btn-block">
                  <i className="fas fa-sign-in-alt"></i> Login
                </button>
              </div>

              <div className="text-center mt-20">
                <a href={`${backendUrl}/forgot_password.php`} className="forgot-password">
                  <i className="fas fa-question-circle"></i> Forgot Password?
                </a>
              </div>

              <div className="text-center mt-20" style={{borderTop: '1px solid var(--dark-border)', paddingTop: '20px'}}>
                <p>Don&apos;t have an account? 
                  <Link href="/register">
                    <i className="fas fa-user-plus"></i> Register here
                  </Link>
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
