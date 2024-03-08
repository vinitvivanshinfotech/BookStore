* {
    padding: 0;
    margin: 0
}

.container {
    height: 100vh;
    display: flex;
    justify-content: center;
    background-color: #0605F9
}

.profile {
    position: relative;
    text-align: center;
    margin-top: 60px
}

.profile img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 2px solid red;
    cursor: pointer
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    transition:all 2s;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block
}

.dropdown-content a:hover {
    background-color: #ddd
}

.dropdown:hover .dropdown-content {
    display: block
}

.profile ul {
    background-color: #fff;
    width: 200px;
    height: 190px;
    border-radius: 10px;
    right: 25px;
    top: 7px;
    position: absolute;
    padding: 8px;
    transition: all 0.5s;
    z-index: 1
}

.profile ul::before {
    content: '';
    position: absolute;
    background-color: #fff;
    height: 10px;
    width: 10px;
    top: -5px;
    transform: rotate(45deg)
}

.profile ul li {
    list-style: none;
    text-align: left;
    font-size: 15px;
    padding: 10px;
    display: flex;
    align-items: center;
    transition: all 0.5s;
    cursor: pointer;
    border-radius: 4px
}

.profile ul li:hover {
    background-color: #eee
}

.profile ul li i {
    margin-right: 7px
}