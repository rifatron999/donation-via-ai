<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Donation via AI</title>
  <style>
    body, html {
      margin: 0; padding: 0;
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #4f46e5, #6366f1);
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 20px;
    }
    .container {
      max-width: 900px;
      width: 100%;
      background: rgba(255,255,255,0.1);
      border-radius: 15px;
      padding: 40px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.3);
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-around;
    }
    .text-content {
      flex: 1 1 320px;
      margin-right: 20px;
    }
    .text-content h1 {
      font-size: 3rem;
      margin-bottom: 10px;
      font-weight: 700;
      letter-spacing: 1.5px;
    }
    .text-content p {
      font-size: 1.2rem;
      margin-bottom: 30px;
      line-height: 1.5;
      color: #e0e7ffcc;
    }
    .buttons {
      display: flex;
      gap: 15px;
      justify-content: center;
      flex-wrap: wrap;
    }
    .btn {
      background-color: #2563eb;
      border: none;
      padding: 15px 35px;
      font-size: 1.1rem;
      font-weight: 600;
      color: white;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      transition: background-color 0.3s ease;
      min-width: 130px;
      display: inline-flex;
      justify-content: center;
      align-items: center;
    }
    .btn:hover {
      background-color: #1d4ed8;
    }
    .btn.donate {
      background-color: #ef4444;
    }
    .btn.donate:hover {
      background-color: #dc2626;
    }

    .carousel {
      position: relative;
      width: 400px;
      max-width: 100%;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 6px 15px rgba(0,0,0,0.3);
      flex: 1 1 320px;
      margin-top: 20px;
    }
    .slides {
      display: flex;
      transition: transform 1.5s ease-in-out;
      width: 300%; /* 3 slides */
    }
    .slide {
      flex: 1 0 100%;
      user-select: none;
    }
    .slide img {
      width: 100%;
      display: block;
    }
    .nav-arrow {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background-color: rgba(0,0,0,0.4);
      border: none;
      color: white;
      font-size: 2rem;
      padding: 0 12px;
      cursor: pointer;
      border-radius: 50%;
      user-select: none;
    }
    .nav-arrow.left {
      left: 10px;
    }
    .nav-arrow.right {
      right: 10px;
    }
    @media (max-width: 700px) {
      .container {
        flex-direction: column;
        padding: 30px 20px;
      }
      .text-content {
        margin-right: 0;
        margin-bottom: 25px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="text-content">
      <h1>Donation via AI</h1>
      <p>Empowering donors and vendors through smart, easy, and secure donations.</p>

      <div class="buttons">
        <a href="/login" class="btn">Login</a>
        <a href="/register" class="btn">Register</a>
        <a href="{{ route('donor.donate.form') }}" class="btn donate">Donate Now</a>
      </div>
    </div>

    <div class="carousel" aria-label="Donation images carousel">
      <div class="slides" id="slides">
        <div class="slide">
          <img src="{{ asset('w_images/1.png') }}" alt="Donation illustration 1" />
        </div>
        <div class="slide">
          <img src="{{ asset('w_images/1.png') }}" alt="Donation illustration 1" />
        </div>
      </div>
      <button class="nav-arrow left" aria-label="Previous slide" id="prev">&#10094;</button>
      <button class="nav-arrow right" aria-label="Next slide" id="next">&#10095;</button>
    </div>
  </div>

<script>
  const slides = document.getElementById('slides');
  const totalSlides = slides.children.length;
  let currentIndex = 0;

  function updateCarousel() {
    slides.style.transform = `translateX(-${currentIndex * 100}%)`;
  }

  document.getElementById('prev').addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    updateCarousel();
  });

  document.getElementById('next').addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % totalSlides;
    updateCarousel();
  });

  // Auto-slide every 7 seconds (7000 milliseconds)
  setInterval(() => {
    currentIndex = (currentIndex + 1) % totalSlides;
    updateCarousel();
  }, 7000);
</script>

</body>
</html>
