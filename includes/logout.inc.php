<?php

  // zerstören der Session um Nutzer asuzuloggen.
  // danach weiterleiten aus Startseite
  session_start();
  session_unset();
  session_destroy();
  header('location: ../index.php');
