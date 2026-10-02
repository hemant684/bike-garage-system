import Link from 'next/link'
import Image from 'next/image'
import Navbar from './components/Navbar.jsx'
import Footer from './components/Footer.jsx'
import Reveal from './components/Reveal.jsx'

const Home = () => {
  return (
    <>
      <Navbar />

      {/* Hero Section */}
      <section className="hero">
        <div className="container hero-layout">
          <div className="hero-copy">
            <span className="hero-eyebrow"><i className="fas fa-screwdriver-wrench"></i> Your neighborhood motorcycle specialists</span>
            <h1>Good rides start with <span>great care.</span></h1>
            <p>Expert servicing, honest repairs, and easy online booking. Give your bike the care it deserves, from its next oil change to its next big ride.</p>
            <div className="hero-buttons">
              <Link href="/register" className="btn btn-light">
                <i className="fas fa-calendar-check"></i> Book a service
              </Link>
              <Link href="/services" className="btn btn-outline">
                Explore services <i className="fas fa-arrow-right"></i>
              </Link>
            </div>
            <div className="hero-promise">
              <span><i className="fas fa-check-circle"></i> Skilled mechanics</span>
              <span><i className="fas fa-check-circle"></i> Clear service updates</span>
            </div>
          </div>

          <div className="hero-visual">
            <Image
              src="/images/garage-hero.jpg"
              alt="Motorcycle ready for its next ride"
              width={1400}
              height={933}
              priority
              loading="eager"
              sizes="(max-width: 768px) 100vw, 48vw"
              className="hero-photo"
            />
            <div className="hero-photo-shade" />
            <div className="hero-photo-caption">
              <span className="caption-icon"><i className="fas fa-wrench"></i></span>
              <span><strong>Ready for every road</strong><small>Care that keeps you moving</small></span>
            </div>
            <div className="hero-photo-tag"><i className="fas fa-circle-check"></i> Service made simple</div>
          </div>
        </div>
      </section>

      {/* Stats Section */}
      <section className="stats-section">
        <div className="container">
          <Reveal as="div" className="stats-grid">
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
          </Reveal>
        </div>
      </section>

      {/* Bike Showcase */}
      <section className="bike-showcase">
        <div className="container">
          <Reveal>
            <div className="section-heading">
              <span className="section-kicker">Thoughtful care, every mile</span>
              <h2><i className="fas fa-bicycle"></i> A better ride starts here</h2>
              <p>From a quick tune-up to a complete rebuild, our team takes care of the details.</p>
            </div>
          </Reveal>
          <div className="bike-grid">
            <Reveal as="article" className="bike-card" delay={0}>
              <div className="bike-image">
                <Image src="/images/sports-bike.jpg" alt="Motorcycle out for a ride" fill sizes="(max-width: 768px) 100vw, 33vw" className="bike-photo" />
                <span className="bike-badge">Popular</span>
              </div>
              <div className="bike-content">
                <h3>Sports Bike Service</h3>
                <p>Specialized care for high-performance sports bikes including engine tuning, fairing repairs, and performance upgrades.</p>
                <div className="bike-price">From ₹1,500</div>
                <Link href="/services" className="btn btn-outline" style={{width: '100%', textAlign: 'center'}}>
                  <i className="fas fa-info-circle"></i> Learn More
                </Link>
              </div>
            </Reveal>

            <Reveal as="article" className="bike-card" delay={90}>
              <div className="bike-image">
                <Image src="/images/garage-hero.jpg" alt="Cruiser motorcycle parked and ready to ride" fill sizes="(max-width: 768px) 100vw, 33vw" className="bike-photo" />
              </div>
              <div className="bike-content">
                <h3>Cruiser Bike Service</h3>
                <p>Expert maintenance for cruiser bikes including leather care, custom modifications, and long-distance touring prep.</p>
                <div className="bike-price">From ₹1,200</div>
                <Link href="/services" className="btn btn-outline" style={{width: '100%', textAlign: 'center'}}>
                  <i className="fas fa-info-circle"></i> Learn More
                </Link>
              </div>
            </Reveal>

            <Reveal as="article" className="bike-card" delay={180}>
              <div className="bike-image">
                <Image src="/images/workshop-service.jpg" alt="A close-up view of motorcycle engine components" fill sizes="(max-width: 768px) 100vw, 33vw" className="bike-photo" />
                <span className="bike-badge" style={{background: 'var(--garage-green)'}}>Economical</span>
              </div>
              <div className="bike-content">
                <h3>Scooter Service</h3>
                <p>Quick and affordable servicing for scooters including CVT maintenance, belt replacement, and body repairs.</p>
                <div className="bike-price">From ₹500</div>
                <Link href="/services" className="btn btn-outline" style={{width: '100%', textAlign: 'center'}}>
                  <i className="fas fa-info-circle"></i> Learn More
                </Link>
              </div>
            </Reveal>
          </div>
        </div>
      </section>

      <section className="process-section">
        <div className="container process-layout">
          <Reveal className="process-copy">
            <span className="section-kicker">No guesswork. Just good work.</span>
            <h2>Getting your bike serviced should be the easy part.</h2>
            <p>Book a visit in minutes. Our mechanics take it from there, keeping you in the loop at every turn.</p>
            <Link href="/register" className="text-link">
              Get your first service booked <i className="fas fa-arrow-right"></i>
            </Link>
          </Reveal>
          <div className="process-steps">
            <Reveal as="article" className="process-step" delay={0}>
              <span className="step-number">01</span>
              <span className="step-icon"><i className="fas fa-calendar-check"></i></span>
              <div><h3>Choose your service</h3><p>Tell us what your bike needs and pick a time that works for you.</p></div>
            </Reveal>
            <Reveal as="article" className="process-step" delay={100}>
              <span className="step-number">02</span>
              <span className="step-icon"><i className="fas fa-screwdriver-wrench"></i></span>
              <div><h3>Our experts get to work</h3><p>Skilled mechanics inspect, service, and repair your bike with care.</p></div>
            </Reveal>
            <Reveal as="article" className="process-step" delay={200}>
              <span className="step-number">03</span>
              <span className="step-icon"><i className="fas fa-road"></i></span>
              <div><h3>Ride away confidently</h3><p>Get clear updates and pick up a bike ready for the road ahead.</p></div>
            </Reveal>
          </div>
        </div>
      </section>

      <section className="workshop-feature">
        <div className="container">
          <Reveal className="workshop-feature-card">
            <div className="workshop-feature-photo">
              <Image
                src="/images/workshop-service.jpg"
                alt="Detailed motorcycle components being carefully serviced"
                fill
                sizes="(max-width: 768px) 100vw, 45vw"
              />
              <span className="photo-label"><i className="fas fa-award"></i> Care in every detail</span>
            </div>
            <div className="workshop-feature-copy">
              <span className="section-kicker">The Bike Garage difference</span>
              <h2>Honest advice. Expert hands. No shortcuts.</h2>
              <p>We treat every bike like it’s our own—with careful inspections, dependable parts, and clear answers before work begins.</p>
              <ul>
                <li><i className="fas fa-circle-check"></i> Experienced, detail-focused mechanics</li>
                <li><i className="fas fa-circle-check"></i> Straightforward service recommendations</li>
                <li><i className="fas fa-circle-check"></i> Convenient appointment booking</li>
              </ul>
              <Link href="/services" className="btn btn-primary">See how we can help <i className="fas fa-arrow-right"></i></Link>
            </div>
          </Reveal>
        </div>
      </section>

      {/* Spare Parts */}
      <section className="parts-section">
        <div className="container">
          <Reveal>
            <div className="section-heading">
              <span className="section-kicker">Quality parts, dependable performance</span>
              <h2><i className="fas fa-cogs"></i> The right parts make all the difference</h2>
            </div>
          </Reveal>
          <div className="parts-grid">
            <Reveal as="article" className="part-card" delay={0}>
              <div className="part-icon">
                <i className="fas fa-oil-can"></i>
              </div>
              <h4>Engine Oil</h4>
              <p>Premium synthetic oils for all bike brands</p>
            </Reveal>
            <Reveal as="article" className="part-card" delay={60}>
              <div className="part-icon">
                <i className="fas fa-circle-notch"></i>
              </div>
              <h4>Brake Pads</h4>
              <p>High-performance brake components</p>
            </Reveal>
            <Reveal as="article" className="part-card" delay={120}>
              <div className="part-icon">
                <i className="fas fa-link"></i>
              </div>
              <h4>Chain & Sprocket</h4>
              <p>Durable chain kits and sprockets</p>
            </Reveal>
            <Reveal as="article" className="part-card" delay={180}>
              <div className="part-icon">
                <i className="fas fa-filter"></i>
              </div>
              <h4>Filters</h4>
              <p>Air, oil, and fuel filters</p>
            </Reveal>
            <Reveal as="article" className="part-card" delay={240}>
              <div className="part-icon">
                <i className="fas fa-lightbulb"></i>
              </div>
              <h4>LED Lights</h4>
              <p>Bright LED upgrades and accessories</p>
            </Reveal>
            <Reveal as="article" className="part-card" delay={300}>
              <div className="part-icon">
                <i className="fas fa-shield-alt"></i>
              </div>
              <h4>Helmets</h4>
              <p>Certified safety helmets</p>
            </Reveal>
          </div>
        </div>
      </section>

      {/* Gallery */}
      <section className="gallery-section">
        <div className="container">
          <Reveal>
            <div className="section-heading">
              <span className="section-kicker">A closer look inside the garage</span>
              <h2><i className="fas fa-images"></i> Made for miles of memories</h2>
            </div>
          </Reveal>
          <div className="gallery-grid">
            <Reveal as="article" className="gallery-item" delay={0}>
              <div className="gallery-media">
                <Image src="/images/workshop-service.jpg" alt="Close-up of engine components during maintenance" fill sizes="(max-width: 768px) 100vw, 33vw" />
              </div>
              <div className="gallery-overlay">
                <h4>Engine components</h4>
                <p>Precision in every detail</p>
              </div>
            </Reveal>
            <Reveal as="article" className="gallery-item" delay={80}>
              <div className="gallery-media">
                <Image src="/images/garage-hero.jpg" alt="Motorcycle prepared for the road" fill sizes="(max-width: 768px) 100vw, 33vw" />
              </div>
              <div className="gallery-overlay">
                <h4>Built for the open road</h4>
                <p>Care for the journey ahead</p>
              </div>
            </Reveal>
            <Reveal as="article" className="gallery-item" delay={160}>
              <div className="gallery-media">
                <Image src="/images/sports-bike.jpg" alt="Motorcycle riding across an open road" fill sizes="(max-width: 768px) 100vw, 33vw" />
              </div>
              <div className="gallery-overlay">
                <h4>Made for everyday rides</h4>
                <p>Keep your daily ride moving</p>
              </div>
            </Reveal>
            <Reveal as="article" className="gallery-item" delay={0}>
              <div className="gallery-media">
                <Image src="/images/workshop-service.jpg" alt="Detailed view of workshop service work" fill sizes="(max-width: 768px) 100vw, 33vw" />
              </div>
              <div className="gallery-overlay">
                <h4>Mechanical details</h4>
                <p>Thoughtful work, down to the last part</p>
              </div>
            </Reveal>
            <Reveal as="article" className="gallery-item" delay={80}>
              <div className="gallery-media">
                <Image src="/images/garage-hero.jpg" alt="Well-maintained bike after a service" fill sizes="(max-width: 768px) 100vw, 33vw" />
              </div>
              <div className="gallery-overlay">
                <h4>Ready for the next ride</h4>
                <p>Reliable care along the way</p>
              </div>
            </Reveal>
            <Reveal as="article" className="gallery-item" delay={160}>
              <div className="gallery-media">
                <Image src="/images/sports-bike.jpg" alt="A bike and rider heading out on a ride" fill sizes="(max-width: 768px) 100vw, 33vw" />
              </div>
              <div className="gallery-overlay">
                <h4>Make every ride count</h4>
                <p>More confidence on the road</p>
              </div>
            </Reveal>
          </div>
        </div>
      </section>

      <section className="benefits-section">
        <div className="container">
          <Reveal>
            <div className="section-heading">
              <span className="section-kicker">Good work. Good people. Good rides.</span>
              <h2><i className="fas fa-heart"></i> A garage that gets riders</h2>
            </div>
          </Reveal>
          <div className="benefits-grid">
            <Reveal as="article" className="benefit-card" delay={0}>
              <span className="benefit-icon"><i className="fas fa-magnifying-glass"></i></span>
              <h3>We look closer</h3>
              <p>Careful inspections help us understand what your bike needs before work begins.</p>
            </Reveal>
            <Reveal as="article" className="benefit-card" delay={100}>
              <span className="benefit-icon"><i className="fas fa-comments"></i></span>
              <h3>We keep it clear</h3>
              <p>Get straightforward recommendations and service updates without the guesswork.</p>
            </Reveal>
            <Reveal as="article" className="benefit-card" delay={200}>
              <span className="benefit-icon"><i className="fas fa-road"></i></span>
              <h3>We care about the ride</h3>
              <p>Our goal is simple: help you get back out there feeling good about your bike.</p>
            </Reveal>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section id="contact" className="contact-cta">
        <div className="container">
          <Reveal className="contact-cta-content">
          <span className="section-kicker">Your next ride starts here</span>
          <h2><i className="fas fa-motorcycle"></i> Give your bike the care it deserves.</h2>
          <p style={{margin: '20px 0', opacity: 0.9, fontSize: '1.1rem'}}>Book your next visit and let our team help you get back to the ride.</p>
          <div className="hero-buttons">
            <Link href="/register" className="btn btn-light">
              <i className="fas fa-user-plus"></i> Create Account
            </Link>
            <a href="mailto:info@bikegarage.com" className="btn btn-outline">
              <i className="fas fa-phone-alt"></i> Contact Us
            </a>
          </div>
          </Reveal>
        </div>
      </section>

      <Footer />
    </>
  );
};

export default Home;
