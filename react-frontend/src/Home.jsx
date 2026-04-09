import Navbar from './components/Navbar.jsx'
import Footer from './components/Footer.jsx'

const Home = () => {
  return (
    <>
      <Navbar />

      {/* Hero Section */}
      <section className="hero">
        <div className="container">
          <h1><i className="fas fa-motorcycle"></i> Welcome to Bike Garage</h1>
          <p>Professional bike servicing and maintenance at your fingertips. Book appointments, track service status, and manage your bike repairs online.</p>
          <div className="hero-buttons">
            <a href="/register" className="btn btn-light">
              <i className="fas fa-user-plus"></i> Register Now
            </a>
            <a href="/services" className="btn btn-outline">
              <i className="fas fa-tools"></i> View Services
            </a>
          </div>
        </div>
      </section>

      {/* Stats Section */}
      <section className="stats-section">
        <div className="container">
          <div className="stats-grid">
            <div className="stat-item">
              <i className="fas fa-motorcycle"></i>
              <div className="number">10,000+</div>
              <div className="label">Bikes Serviced</div>
            </div>
            <div className="stat-item">
              <i className="fas fa-users"></i>
              <div className="number">5,000+</div>
              <div className="label">Happy Customers</div>
            </div>
            <div className="stat-item">
              <i className="fas fa-award"></i>
              <div className="number">15+</div>
              <div className="label">Expert Mechanics</div>
            </div>
            <div className="stat-item">
              <i className="fas fa-star"></i>
              <div className="number">4.8</div>
              <div className="label">Customer Rating</div>
            </div>
          </div>
        </div>
      </section>

      {/* Bike Showcase */}
      <section className="bike-showcase">
        <div className="container">
          <h2><i className="fas fa-bicycle"></i> Premium Bike Services</h2>
          <div className="bike-grid">
            <div className="bike-card">
              <div className="bike-image">
                <div className="bike-image-placeholder placeholder-sports">
                  <i className="fas fa-motorcycle"></i>
                </div>
                <span className="bike-badge">Popular</span>
              </div>
              <div className="bike-content">
                <h3>Sports Bike Service</h3>
                <p>Specialized care for high-performance sports bikes including engine tuning, fairing repairs, and performance upgrades.</p>
                <div className="bike-price">From ₹1,500</div>
                <a href="/services" className="btn btn-outline" style={{width: '100%', textAlign: 'center'}}>
                  <i className="fas fa-info-circle"></i> Learn More
                </a>
              </div>
            </div>

            <div className="bike-card">
              <div className="bike-image">
                <div className="bike-image-placeholder placeholder-cruiser">
                  <i className="fas fa-motorcycle"></i>
                </div>
              </div>
              <div className="bike-content">
                <h3>Cruiser Bike Service</h3>
                <p>Expert maintenance for cruiser bikes including leather care, custom modifications, and long-distance touring prep.</p>
                <div className="bike-price">From ₹1,200</div>
                <a href="/services" className="btn btn-outline" style={{width: '100%', textAlign: 'center'}}>
                  <i className="fas fa-info-circle"></i> Learn More
                </a>
              </div>
            </div>

            <div className="bike-card">
              <div className="bike-image">
                <div className="bike-image-placeholder placeholder-scooter">
                  <i className="fas fa-scooter"></i>
                </div>
                <span className="bike-badge" style={{background: 'var(--garage-green)'}}>Economical</span>
              </div>
              <div className="bike-content">
                <h3>Scooter Service</h3>
                <p>Quick and affordable servicing for scooters including CVT maintenance, belt replacement, and body repairs.</p>
                <div className="bike-price">From ₹500</div>
                <a href="/services" className="btn btn-outline" style={{width: '100%', textAlign: 'center'}}>
                  <i className="fas fa-info-circle"></i> Learn More
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Spare Parts */}
      <section className="parts-section">
        <div className="container">
          <h2><i className="fas fa-cogs"></i> Quality Spare Parts</h2>
          <div className="parts-grid">
            <div className="part-card">
              <div className="part-icon">
                <i className="fas fa-oil-can"></i>
              </div>
              <h4>Engine Oil</h4>
              <p>Premium synthetic oils for all bike brands</p>
            </div>
            <div className="part-card">
              <div className="part-icon">
                <i className="fas fa-circle-notch"></i>
              </div>
              <h4>Brake Pads</h4>
              <p>High-performance brake components</p>
            </div>
            <div className="part-card">
              <div className="part-icon">
                <i className="fas fa-link"></i>
              </div>
              <h4>Chain & Sprocket</h4>
              <p>Durable chain kits and sprockets</p>
            </div>
            <div className="part-card">
              <div className="part-icon">
                <i className="fas fa-filter"></i>
              </div>
              <h4>Filters</h4>
              <p>Air, oil, and fuel filters</p>
            </div>
            <div className="part-card">
              <div className="part-icon">
                <i className="fas fa-lightbulb"></i>
              </div>
              <h4>LED Lights</h4>
              <p>Bright LED upgrades and accessories</p>
            </div>
            <div className="part-card">
              <div className="part-icon">
                <i className="fas fa-shield-alt"></i>
              </div>
              <h4>Helmets</h4>
              <p>Certified safety helmets</p>
            </div>
          </div>
        </div>
      </section>

      {/* Gallery */}
      <section className="gallery-section">
        <div className="container">
          <h2><i className="fas fa-images"></i> Our Work Gallery</h2>
          <div className="gallery-grid">
            <div className="gallery-item">
              <div className="gallery-placeholder placeholder-sports">
                <i className="fas fa-wrench"></i>
              </div>
              <div className="gallery-overlay">
                <h4>Engine Repair</h4>
                <p>Complete engine overhaul</p>
              </div>
            </div>
            <div className="gallery-item">
              <div className="gallery-placeholder placeholder-cruiser">
                <i className="fas fa-paint-brush"></i>
              </div>
              <div className="gallery-overlay">
                <h4>Custom Paint</h4>
                <p>Premium finishing</p>
              </div>
            </div>
            <div className="gallery-item">
              <div className="gallery-placeholder placeholder-scooter">
                <i className="fas fa-tools"></i>
              </div>
              <div className="gallery-overlay">
                <h4>Regular Service</h4>
                <p>Maintenance & tuning</p>
              </div>
            </div>
            <div className="gallery-item">
              <div className="gallery-placeholder" style={{background: 'linear-gradient(135deg, #7209b7 0%, #1a1a2e 100%)'}}>
                <i className="fas fa-car-battery"></i>
              </div>
              <div className="gallery-overlay">
                <h4>Electrical Work</h4>
                <p>Wiring & diagnostics</p>
              </div>
            </div>
            <div className="gallery-item">
              <div className="gallery-placeholder" style={{background: 'linear-gradient(135deg, #4361ee 0%, #1a1a2e 100%)'}}>
                <i className="fas fa-shield-alt"></i>
              </div>
              <div className="gallery-overlay">
                <h4>Insurance Work</h4>
                <p>Claim processing</p>
              </div>
            </div>
            <div className="gallery-item">
              <div className="gallery-placeholder" style={{background: 'linear-gradient(135deg, #3a0ca3 0%, #1a1a2e 100%)'}}>
                <i className="fas fa-snowflake"></i>
              </div>
              <div className="gallery-overlay">
                <h4>AC Service</h4>
                <p>Cooling system maintenance</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Video Section */}
      <section className="video-section">
        <div className="container">
          <h2><i className="fas fa-video"></i> Watch Our Services</h2>
          <div className="video-grid">
            <div className="video-card">
              <div className="video-thumbnail">
                <div style={{width: '100%', height: '100%', display: 'flex', alignItems: 'center', justifyContent: 'center', background: 'linear-gradient(135deg, #e63946 0%, #1a1a2e 100%)'}}>
                  <div className="play-button">
                    <i className="fas fa-play"></i>
                  </div>
                </div>
              </div>
              <div className="video-content">
                <h4>Full Service Process</h4>
                <p>Watch our expert mechanics perform a complete bike service from start to finish.</p>
              </div>
            </div>
            {/* Similar for other videos */}
            <div className="video-card">
              <div className="video-thumbnail">
                <div style={{width: '100%', height: '100%', display: 'flex', alignItems: 'center', justifyContent: 'center', background: 'linear-gradient(135deg, #f77f00 0%, #1a1a2e 100%)'}}>
                  <div className="play-button">
                    <i className="fas fa-play"></i>
                  </div>
                </div>
              </div>
              <div className="video-content">
                <h4>Before & After</h4>
                <p>Amazing transformations of bikes that came in damaged and left looking brand new.</p>
              </div>
            </div>
            <div className="video-card">
              <div className="video-thumbnail">
                <div style={{width: '100%', height: '100%', display: 'flex', alignItems: 'center', justifyContent: 'center', background: 'linear-gradient(135deg, #2a9d8f 0%, #1a1a2e 100%)'}}>
                  <div className="play-button">
                    <i className="fas fa-play"></i>
                  </div>
                </div>
              </div>
              <div className="video-content">
                <h4>Customer Reviews</h4>
                <p>Hear from our satisfied customers about their experience with Bike Garage.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section style={{background: 'linear-gradient(135deg, var(--primary-color), var(--garage-red))', color: 'white', padding: '80px 0', textAlign: 'center'}}>
        <div className="container">
          <h2><i className="fas fa-motorcycle"></i> Ready to Experience Quality Service?</h2>
          <p style={{margin: '20px 0', opacity: 0.9, fontSize: '1.1rem'}}>Join thousands of satisfied customers who trust us with their bikes</p>
          <div className="hero-buttons">
            <a href="/register" className="btn btn-light">
              <i className="fas fa-user-plus"></i> Create Account
            </a>
            <a href="/contact" className="btn btn-outline" style={{borderColor: 'white', color: 'white'}}>
              <i className="fas fa-phone-alt"></i> Contact Us
            </a>
          </div>
        </div>
      </section>

      <Footer />
    </>
  );
};

export default Home;
