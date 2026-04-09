import Navbar from '../components/Navbar.jsx'
import Footer from '../components/Footer.jsx'

const Services = () => {
  return (
    <>
      {/* Hero Section */}
      <section className="services-hero">
        <div className="container">
          <h1><i className="fas fa-tools"></i> Our Services</h1>
          <p>Professional bike servicing and repair solutions tailored to keep your bike running smoothly and safely</p>
        </div>
      </section>

      {/* Main Services */}
      <section className="services-section">
        <div className="container">
          <div className="section-header">
            <h2><i className="fas fa-wrench"></i> Comprehensive Bike Services</h2>
            <p>From routine maintenance to complex repairs, we offer a wide range of services for all bike brands</p>
          </div>
          
          <div className="services-grid">
            {/* Regular Service */}
            <div className="service-card">
              <div className="service-card-header">
                <div className="service-icon">
                  <i className="fas fa-oil-can"></i>
                </div>
                <h3>Regular Service</h3>
                <div className="price">From ₹500</div>
              </div>
              <div className="service-card-body">
                <ul className="service-features">
                  <li><i className="fas fa-check"></i> Oil change & filter cleaning</li>
                  <li><i className="fas fa-check"></i> General inspection</li>
                  <li><i className="fas fa-check"></i> Chain lubrication</li>
                  <li><i className="fas fa-check"></i> Air filter cleaning</li>
                  <li><i className="fas fa-check"></i> Brake adjustment</li>
                  <li><i className="fas fa-check"></i> 100+ point check</li>
                </ul>
              </div>
              <div className="service-card-footer">
                <a href="/register" className="btn btn-primary">
                  <i className="fas fa-calendar-check"></i> Book Now
                </a>
              </div>
            </div>

            {/* Major Service */}
            <div className="service-card">
              <div className="service-card-header">
                <div className="service-icon">
                  <i className="fas fa-tools"></i>
                </div>
                <h3>Major Service</h3>
                <div className="price">From ₹1,500</div>
              </div>
              <div className="service-card-body">
                <ul className="service-features">
                  <li><i className="fas fa-check"></i> Everything in Regular Service</li>
                  <li><i className="fas fa-check"></i> Complete engine check</li>
                  <li><i className="fas fa-check"></i> Spark plug replacement</li>
                  <li><i className="fas fa-check"></i> Carburetor tuning</li>
                  <li><i className="fas fa-check"></i> Clutch adjustment</li>
                  <li><i className="fas fa-check"></i> Suspension check</li>
                </ul>
              </div>
              <div className="service-card-footer">
                <a href="/register" className="btn btn-primary">
                  <i className="fas fa-calendar-check"></i> Book Now
                </a>
              </div>
            </div>

            {/* Repair Services */}
            <div className="service-card">
              <div className="service-card-header">
                <div className="service-icon">
                  <i className="fas fa-wrench"></i>
                </div>
                <h3>Repair Services</h3>
                <div className="price">Custom Pricing</div>
              </div>
              <div className="service-card-body">
                <ul className="service-features">
                  <li><i className="fas fa-check"></i> Brake repair & replacement</li>
                  <li><i className="fas fa-check"></i> Chain & sprocket replacement</li>
                  <li><i className="fas fa-check"></i> Engine repairs</li>
                  <li><i className="fas fa-check"></i> Electrical system repair</li>
                  <li><i className="fas fa-check"></i> Clutch & gear issues</li>
                  <li><i className="fas fa-check"></i> Free diagnosis</li>
                </ul>
              </div>
              <div className="service-card-footer">
                <a href="/register" className="btn btn-primary">
                  <i className="fas fa-calendar-check"></i> Book Now
                </a>
              </div>
            </div>

            {/* Insurance Claim */}
            <div className="service-card">
              <div className="service-card-header">
                <div className="service-icon">
                  <i className="fas fa-shield-alt"></i>
                </div>
                <h3>Insurance Claims</h3>
                <div className="price">TPA Supported</div>
              </div>
              <div className="service-card-body">
                <ul className="service-features">
                  <li><i className="fas fa-check"></i> Accidental repair</li>
                  <li><i className="fas fa-check"></i> Cashless claims</li>
                  <li><i className="fas fa-check"></i> Insurance documentation</li>
                  <li><i className="fas fa-check"></i> Claim assistance</li>
                  <li><i className="fas fa-check"></i> All TPA supported</li>
                  <li><i className="fas fa-check"></i> Quick turnaround</li>
                </ul>
              </div>
              <div className="service-card-footer">
                <a href="/register" className="btn btn-primary">
                  <i className="fas fa-calendar-check"></i> Book Now
                </a>
              </div>
            </div>

            {/* AC Service */}
            <div className="service-card">
              <div className="service-card-header">
                <div className="service-icon">
                  <i className="fas fa-snowflake"></i>
                </div>
                <h3>AC Service</h3>
                <div className="price">From ₹800</div>
              </div>
              <div className="service-card-body">
                <ul className="service-features">
                  <li><i className="fas fa-check"></i> AC gas refill</li>
                  <li><i className="fas fa-check"></i> Cooling system repair</li>
                  <li><i className="fas fa-check"></i> Compressor check</li>
                  <li><i className="fas fa-check"></i> Leak detection</li>
                  <li><i className="fas fa-check"></i> Belt replacement</li>
                  <li><i className="fas fa-check"></i> Performance test</li>
                </ul>
              </div>
              <div className="service-card-footer">
                <a href="/register" className="btn btn-primary">
                  <i className="fas fa-calendar-check"></i> Book Now
                </a>
              </div>
            </div>

            {/* Denting & Painting */}
            <div className="service-card">
              <div className="service-card-header">
                <div className="service-icon">
                  <i className="fas fa-paint-roller"></i>
                </div>
                <h3>Denting & Painting</h3>
                <div className="price">Custom Pricing</div>
              </div>
              <div className="service-card-body">
                <ul className="service-features">
                  <li><i className="fas fa-check"></i> Scratch removal</li>
                  <li><i className="fas fa-check"></i> Full body painting</li>
                  <li><i className="fas fa-check"></i> Spot painting</li>
                  <li><i className="fas fa-check"></i> Paint protection</li>
                  <li><i className="fas fa-check"></i> Premium paints</li>
                  <li><i className="fas fa-check"></i> Color matching</li>
                </ul>
              </div>
              <div className="service-card-footer">
                <a href="/register" className="btn btn-primary">
                  <i className="fas fa-calendar-check"></i> Book Now
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </>
  );
};

export default Services;
