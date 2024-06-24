<?php
function get_companies($conn) {
    $sql = "SELECT id, name, industry, description, website, contact_email FROM companies";
    return $conn->query($sql);
}

function get_company_by_id($conn, $id) {
    $sql = "SELECT id, name, industry, description, website, contact_email FROM companies WHERE id = $id";
    return $conn->query($sql)->fetch_assoc();
}

function add_company($conn, $name, $industry, $description, $website, $contact_email) {
    $sql = "INSERT INTO companies (name, industry, description, website, contact_email)
            VALUES ('$name', '$industry', '$description', '$website', '$contact_email')";
    return $conn->query($sql);
}

function update_company($conn, $id, $name, $industry, $description, $website, $contact_email) {
    $sql = "UPDATE companies SET name='$name', industry='$industry', description='$description', website='$website', contact_email='$contact_email' WHERE id=$id";
    return $conn->query($sql);
}

function delete_company($conn, $id) {
    $sql = "DELETE FROM companies WHERE id = $id";
    return $conn->query($sql);
}
?>