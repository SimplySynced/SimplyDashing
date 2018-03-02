<?php
header ("content-type: text/xml");
?>

<CiscoIPPhoneMenu>
    <Title>OpenHAB Control</Title>
    <Prompt>OpenHAB Control</Prompt>
    <MenuItem>
        <Name>Living Room Off</Name>
        <URL>http://10.1.1.40:8080/CMD?Light_LivRoom_AllLights_Sw=OFF</URL>
    </MenuItem>
</CiscoIPPhoneMenu>
