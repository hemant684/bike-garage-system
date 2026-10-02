import Link from 'next/link'
import Image from 'next/image'
import Navbar from '../components/Navbar.jsx'
import Footer from '../components/Footer.jsx'
import Reveal from '../components/Reveal.jsx'

const Services = () => {
  return (
    <>
      <Navbar />
      <section className="services-hero">
        <div className="container services-hero-layout">
          <Reveal className="services-hero-copy">
            <span className="section-kicker">Small tune-up or big repair</span>
            <h1><i className="fas fa-tools"></i> Care for every kind of ride.</h1>
            <p>From everyday scooters to weekend cruisers, get thoughtful service from people who know bikes.</p>
            <Link href="/register" className="btn btn-primary">
              <i className="fas fa-calendar-check"></i> Book your visit
            </Link>
          </Reveal>
          <Reveal className="services-hero-photo" delay={120}>
            <Image
              src="/images/sports-bike.jpg"
              alt="Motorcycle and rider travelling on an open road"
              fill
              priority
              loading="eager"
              sizes="(max-width: 768px) 100vw, 48vw"
            />
            <span><i className="fas fa-shield-heart"></i> Made for the miles ahead</span>
          </Reveal>
        </div>
      </section>

      <section className="service-assurances" aria-label="Our service promises">
        <div className="container service-assurances-grid">
          <span><i className="fas fa-user-gear"></i> Skilled mechanics</span>
          <span><i className="fas fa-clipboard-check"></i> Careful inspections</span>
          <span><i className="fas fa-comments"></i> Clear communication</span>
        </div>
      </section>

      <section className="services-section">
        <div className="container">
          <Reveal>
            <div className="section-header section-heading">
              <span className="section-kicker">One trusted stop for your bike</span>
              <h2><i className="fas fa-wrench"></i> Find the care you need</h2>
              <p>Pick a service to get started. We’ll help you figure out the details when you arrive.</p>
            </div>
          </Reveal>
          
          <Reveal as="div" className="services-grid">
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
                <Link href="/register" className="btn btn-primary">
                  <i className="fas fa-calendar-check"></i> Book Now
                </Link>
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
                <Link href="/register" className="btn btn-primary">
                  <i className="fas fa-calendar-check"></i> Book Now
                </Link>
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
                <Link href="/register" className="btn btn-primary">
                  <i className="fas fa-calendar-check"></i> Book Now
                </Link>
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
                <Link href="/register" className="btn btn-primary">
                  <i className="fas fa-calendar-check"></i> Book Now
                </Link>
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
                <Link href="/register" className="btn btn-primary">
                  <i className="fas fa-calendar-check"></i> Book Now
                </Link>
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
                <Link href="/register" className="btn btn-primary">
                  <i className="fas fa-calendar-check"></i> Book Now
                </Link>
              </div>
            </div>
          </Reveal>
        </div>
      </section>

      <section className="services-bottom-cta">
        <div className="container">
          <Reveal className="services-bottom-cta-inner">
            <div>
              <span className="section-kicker">Not sure what your bike needs?</span>
              <h2>We’ll help you find the right service.</h2>
              <p>Start with a booking and tell our team what’s going on.</p>
            </div>
            <Link href="/register" className="btn btn-light">
              Talk to our team <i className="fas fa-arrow-right"></i>
            </Link>
          </Reveal>
        </div>
      </section>

      <Footer />
    </>
  );
};

export default Services;
