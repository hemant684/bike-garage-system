const Navbar = () => {
  return (
    <nav className="navbar">
      <div className="container">
        <a href="/" className="navbar-brand">
          <i className="fas fa-motorcycle"></i> Bike Garage
        </a>
        <ul className="nav-links">
          <li><a href="/" className="active">Home</a></li>
          <li><a href="/services">Services</a></li>
          <li><a href="/about">About</a></li>
          <li><a href="/faq">FAQ</a></li>
          <li><a href="/contact">Contact</a></li>
          <li><a href="/login">Login</a></li>
          <li><a href="/register">Register</a></li>
          <li><a href="/admin" style={{color: 'var(--garage-orange)'}}>Admin</a></li>
        </ul>
      </div>
    </nav>
  );
};

export default Navbar;
