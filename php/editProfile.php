@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
  color: #2d3e4e;
}

body {
  background-color: #e8eceb;
}

nav {
  width: 100%;
  height: 91px;
  background-color: #8cbdb9;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  position: fixed;
  z-index: 9;

  div {
    width: 90%;
    display: flex;
    display: flex;
    align-items: center;

    i {
      font-size: 2.5rem;
      margin-right: 4rem;
    }

    h1 {
      font-size: 30px;
      font-weight: bold;
    }
  }
}

.hero {
  background-image: url("../img/hero.png");
  background-position: center;
  background-size: cover;
  height: 300px;
  position: relative;

  .hero_container {
    width: 80%;
    margin: 0 auto;
    position: relative;
    height: 100%;

    .profile_picture_container {
      border-radius: 50%;
      position: absolute;
      width: 150px;
      height: 150px;
      bottom: -70px;
      overflow: hidden;

      .profile_picture {
        width: 100%;
        height: 100%;
      }

      .layer {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(182, 182, 182, 0.438);
        z-index: 2;

        display: flex;
        justify-content: center;
        align-items: center;

        i {
          font-size: 2rem;
          color: white;
        }
      }
    }
  }

  .hero_layer {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(182, 182, 182, 0.438);
    z-index: 2;

    display: flex;
    justify-content: center;
    align-items: center;

    i {
      font-size: 2rem;
      color: white;
      transform: translateY(100%);
    }
  }
}

main {
  padding-top: 100px;
  height: 120vh;

  .container {
    width: 80%;
    margin: 0 auto;
    padding-bottom: 0;

    .card_container {
      width: 90%;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 2rem;

      .card {
        padding: 1.5rem 2rem;
        border: 2px solid #2d3e4e;
        border-radius: 10px;

        display: flex;
        justify-content: space-between;
        align-items: center;

        p {
          font-size: 1.25rem;
        }

        input {
          font-size: 20px;
          padding: 5px 10px;
          border: none;
          outline: none;
          border-radius: 10px;
        }
      }
    }

    .btn_container {
      width: 90%;
      margin: 0 auto;
      display: flex;
      justify-content: flex-end;
      margin-top: 3rem;

      button {
        background-color: #8cbdb9;
        color: #2d3e4e;
        font-weight: bold;
        font-size: 1.5rem;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 0.5rem 3rem;
        border-radius: 50px;
      }
    }
  }
}

