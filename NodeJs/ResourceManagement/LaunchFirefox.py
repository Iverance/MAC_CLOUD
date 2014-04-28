from selenium import webdriver
from selenium.common.exceptions import TimeoutException
from selenium.webdriver.support import expected_conditions as EC # available since 2.26.0
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
from selenium.webdriver.support.ui import WebDriverWait
from selenium import selenium
import time, unittest
from subprocess import call

call(["curl", "http://localhost:8000/resource/updateLaunchedAgent?agentId=57"]);

driver = webdriver.Remote(command_executor='http://localhost:4444/wd/hub', desired_capabilities=DesiredCapabilities.FIREFOX);
driver.get("http://www.google.com");
driver.quit()

