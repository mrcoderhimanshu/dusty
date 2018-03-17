<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<style>
    .padB{ margin-bottom: 10px;}
</style>
</head>
<body>
    <br/>
    <form action="emi.php"  method="post" name="dusty">
        <div class="col-md-6">    
            <div class="row padB">
                <div class="col-md-6">
                    <label>Principal</label>
                </div>
                <div class="col-md-6">
                    <input class="form-control" id="principal" placeholder="Principal" name="principal" value="" required="" type="text">
                </div>
            </div>

            <div class="row padB">
                <div class="col-md-6">
                    <label>Rate</label>
                </div>
                <div class="col-md-6">
                    <input class="form-control" id="Rate" placeholder="Rate" name="rate" value="" required="" type="text">
                </div>
            </div>
            <div class="row padB">
                <div class="col-md-6">
                    <label>Tenure</label>
                </div>
                <div class="col-md-6">
                    <input class="form-control" id="Tenure" placeholder="Tenure" name="tenure" value="" required="" type="text">
                </div>
            </div>
            <div class="row padB">
                <div class="col-md-6">
                    <label>Tenure Type</label>
                </div>
                <div class="col-md-6">
                    <select name="tenureType" class="form-control">
                        <option value="0">Daily</option>
                        <option value="1">Weekly</option>
                        <option value="2">Half Monthly</option>
                        <option value="3">Monthly</option>
                        <option value="4">Quaterly</option>
                        <option value="5">Half Yearly</option>
                        <option value="6">Yearly</option>
                    </select>
                </div>
            </div>
            <div class="row padB">
                <div class="col-md-6">
                    <label>Mode Of Emi</label>
                </div>
                <div class="col-md-6">
                    <select name="emiMode" class="form-control">
                        <option value="0">Daily</option>
                        <option value="1">Weekly</option>
                        <option value="2">Half Monthly</option>
                        <option value="3">Monthly</option>
                        <option value="4">Quaterly</option>
                        <option value="5">Half Yearly</option>
                        <option value="6">Yearly</option>
                    </select>
                </div>
            </div>
            <div class="row padB">
                <div class="col-md-6">
                    <label></label>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
</body>
</html>