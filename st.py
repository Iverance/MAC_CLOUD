from selenium import webdriver
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
from selenium.webdriver.support.ui import WebDriverWait
from selenium import selenium
import time, unittest

driver = webdriver.Remote(command_executor='http://127.0.0.1:4444/wd/hub', desired_capabilities=DesiredCapabilities.FIREFOX)
driver.get("http://www.google.com")

class OnFirefox (unittest.TestCase):
        def setUp(self):
                self.driver = webdriver.Remote(command_executor='http://192.168.152.131:4444/wd/hub/', desired_capabilities=DesiredCapabilities.FIREFOX)
                browser = webdriver.Firefox()
                browser.get('http://www.ubuntu.com/')

			
        def test_Google_Search_FF(self):
                selenium = selenium("localhost", 4444, "firefox", "http://cnn.com/")
                selenium.start()
        def tearDown(self):
                self.driver.quit()

        if __name__ == "__main__":
                unittest.main()

