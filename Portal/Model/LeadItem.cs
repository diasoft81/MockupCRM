namespace Portal.Model
{
    public class LeadItem
    {
        public string CompanyName { get; set; }
        public string CompanyShortName { get; set; }
        public string LeadStatus { get; set; } = "New";
        public DateTime? ExpectedCloseDate { get; set; }
        public string LeadSource { get; set; }
        public string ReviewedBy { get; set; }
        public DateTime? ReviewedDate { get; set; }
        public string ApprovedBy { get; set; }
        public DateTime? ApprovedDate { get; set; }

        public string CustomerName;
        public string ContactPerson;
        public string Email;
        public string Phone;
        public string IndustrySegment;
        public string CustomerCategory;
        public List<ProductItem> ProductNeeds = new();
        public string AdditionalNotes;
        public string Name { get; set; }
        public string Company { get; set; }
        public string Stage { get; set; }
        public string Status { get; set; }
        public LeadItem()
        {
        }
        public LeadItem(string name, string company, string stage, string status = "")
        {
            Name = name;
            Company = company;
            Stage = stage;
            Status = status;
        }
    }
}
